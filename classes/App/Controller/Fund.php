<?php
namespace App\Controller;

class Fund extends \App\Page {

    public function action_index(){
        if(!$this->logged_in('admin'))
            return;

        $this->view->message = $this->pixie->auth->user()->email;
        $this->view->subview = '/admin/admin';
    }

    public function action_calc_fund() {
        if(!$this->logged_in('admin'))
            return;

        if ($this->request->method=="POST") {
            $year = $this->request->post('year');
            $cf = $this->pixie->orm->get('calcfund')->where('year',$year)->find();
            if (!$cf->loaded()) {
                $cf = $this->pixie->orm->get('calcfund');
            }
            $fsu = $this->request->post('fsu');
            $cf->year = $year;
            $cf->fsu = $fsu;
            $cf->date = date("Y-m-d H:i");

            $nu = 0;
            $nshu = 0;

            // выпускайте тяжелую накроманию!
            $awards = $this->pixie->orm->get('award')->where('year',$year)->find_all();

            // считаем сумму преподователей и студентов
            foreach ($awards as $aw) {
                $nu += $aw->faculty->nf;
                $nshu += $aw->faculty->nprf;
            }

            // cохраним расчет
            $cf->save();

            // считаем приведенный бал универа

            $facs = $this->pixie->orm->get('faculty')->find_all();
            $pbu = 0.0;
            foreach ($facs as $f) {
                $awa = $this->pixie->orm->get('award')->where('faculties_id',$f->id)->where('year',$year)->find_all();
                $pbf = 0.0;
                foreach ($awa as $a) {
                    $nf = $a->faculty->nf;
                    $nshf = $a->faculty->nprf;
                    $k = $nf/$nu + $nshf/$nshu;
                    $pbf += $a->sum * $k;
                }
                $pbu += $pbf;
            }

//            $awards = $this->pixie->orm->get('award')->where('year',$year)->find_all();
//            $pbu = 0.0;
//            foreach ($awards as $aw) {
//
//                $pbu += $aw->sum * $kf;
//            }
            $s = $fsu/$pbu;
            $sum  = 0.0;
            $fsf = 0.0;
            $facs = $this->pixie->orm->get('faculty')->find_all();
            foreach ($facs as $fa) {
                $awa = $this->pixie->orm->get('award')->where('faculties_id',$fa->id)->where('year',$year)->find_all();
                $pbf = 0.0;
                foreach ($awa as $a) {
                    $nf = $a->faculty->nf;
                    $nshf = $a->faculty->nprf;
                    $k = $nf/$nu + $nshf/$nshu;
                    $pbf += $a->sum * $k;
                }
                $fsf = $pbf * $s;
                $sum += $fsf;

                $oper = $this->pixie->orm->get('operation')->where('calc_fund_idcalc_fund',$cf->idcalc_fund)->where('faculties_id',$fa->id)->find();
                if (!$oper->loaded()) {
                    $oper = $this->pixie->orm->get('operation');
                }

                $oper->calc_fund_idcalc_fund = $cf->idcalc_fund;
                $oper->money = (float) $fsf;
                $oper->faculties_id = $fa->id;
                $oper->save();
            }


//            $sum  = 0.0;
//            $s = $fsu/$pbu;
//            $fsf = 0.0;
//            $awards = $this->pixie->orm->get('award')->where('year',$year)->where('stage_id',1)->find_all();
//            foreach ($awards as $a) {
//                $kf = $a->faculty->nf/$nu + $a->faculty->nprf/$nshu;
//                $pbf = $a->sum * $kf;
//                $fsf = $pbf * $s;
//
//                $oper = $this->pixie->orm->get('operation')->where('calc_fund_idcalc_fund',$cf->idcalc_fund)->where('faculties_id',$a->faculty->id)->find();
//                if (!$oper->loaded()) {
//                    $oper = $this->pixie->orm->get('operation');
//                }
//                $oper->calc_fund_idcalc_fund = $cf->idcalc_fund;
//                $oper->money = (float) $fsf;
//                $sum += $fsf;
//                $oper->faculties_id = $a->faculty->id;
//                $oper->save();
//            }
//
//            $awards = $this->pixie->orm->get('award')->where('year',$year)->where('stage_id',2)->find_all();
//            foreach ($awards as $a) {
//                $kf = $a->faculty->nf/$nu + $a->faculty->nprf/$nshu;
//                $pbf = $a->sum * $kf;
//                $fsf = $pbf * $s;
//
//                $oper = $this->pixie->orm->get('operation')->where('calc_fund_idcalc_fund',$cf->idcalc_fund)->where('faculties_id',$a->faculty->id)->find();
//                if (!$oper->loaded()) {
//                    $oper = $this->pixie->orm->get('operation');
//                }
//                $oper->calc_fund_idcalc_fund = $cf->idcalc_fund;
//                $oper->money = (float)$oper->money +  $fsf;
//                $sum += $fsf;
//                $oper->faculties_id = $a->faculty->id;
//                $oper->save();
//            }
//
//            $awards = $this->pixie->orm->get('award')->where('year',$year)->where('stage_id',3)->find_all();
//            foreach ($awards as $a) {
//                $kf = $a->faculty->nf/$nu + $a->faculty->nprf/$nshu;
//                $pbf = $a->sum * $kf;
//                $fsf = $pbf * $s;
//
//                $oper = $this->pixie->orm->get('operation')->where('calc_fund_idcalc_fund',$cf->idcalc_fund)->where('faculties_id',$a->faculty->id)->find();
//                if (!$oper->loaded()) {
//                    $oper = $this->pixie->orm->get('operation');
//                }
//                $oper->calc_fund_idcalc_fund = $cf->idcalc_fund;
//                $oper->money = (float) $oper->money +  $fsf;
//                $sum += $fsf;
//                $oper->faculties_id = $a->faculty->id;
//                $oper->save();
//            }
            // ,t

            // бежим по фалкулттетам
            $_fac = $this->pixie->orm->get('faculty')->find_all();
            foreach ($_fac as $_f) {
                // соберем 3 аварда в 1
                $awards = $this->pixie->orm->get('awarduser')->with('user')->where('year',$year)->where('a0.faculties_id', $_f->id)->find_all();

                $prf = 0.0;
                // считаем сумму баллов преподавателей выбранного факультета
                foreach ($awards as $aw) {
                    $prf += $aw->sum*$aw->user->rate;
                }

                if ($prf == 0.0) {
                    // все тлен
                    // пользователей без баллов не обрабатываем

                } else {
                    $user_list = $this->pixie->orm->get('user')->with('faculty')->where('a0.id',$a->faculty->id)->find_all();
                    $this->calc_fund_user($year, $au->user->id,$au, $prf);
                }

            }


            // убновляем баллы во всех пользователях данного факультета
//            $awardsuser = $this->pixie->orm->get('awarduser')->where('year',$year)->find_all();
//            foreach ($awardsuser as $au) {
//
//                // соберем 3 аварда в 1
//                $awards = $this->pixie->orm->get('awarduser')->with('user')->where('year',$year)->where('a0.id', $au->user->id)->find_all();
//
//                $prf = 0.0;
//                // считаем сумму баллов преподавателей выбранного факультета
//                foreach ($awards as $aw) {
//                    $prf += $aw->sum*$aw->user->rate;
//                }
//
//                if ($prf == 0.0) {
//                    // все тлен
//                    // пользователей без баллов не обрабатываем
//
//                } else {
//                    $user_list = $this->pixie->orm->get('user')->with('faculty')->where('a0.id',$a->faculty->id)->find_all();
//                    $this->calc_fund_user($year, $au->user->id,$au, $prf);
//                }
//            }


//            echo '/fund/list_fund/'.$year."?sum=".$sum;
            $this->redirect('/fund/list_fund/'.$year);
        } else {
            $this->view->subview = '/fund/calc_fund';
        }


    }


    /**
     * расчитывает баллы для указаного пользователя за указанный год
     */
    public function calc_fund_user($year,$user_id, $award_global, $prf) {

        $fac_id = $this->pixie->orm->get('user')->where("id",$user_id)->find()->faculty->id;

        $cfu = $this->pixie->orm->get('calcfunduser')->where('year',$year)->find();
        if (!$cfu->loaded()) {
            $cfu = $this->pixie->orm->get('calcfunduser');
        }

        $cfu->year = $year;
        $cfu->date = date("Y-m-d H:i");



        $points = $this->get_fsf($fac_id,$year);

        $cfu->money = $points;
        $cfu->save();

        $prp = ($award_global->sum * $award_global->user->rate / $prf) * $cfu->money;
        $oper = $this->pixie->orm->get('operationuser')->where('calc_fund_user_idcalc_fund_user',$cfu->idcalc_fund_user)->where('users_id',$award_global->user->id)->find();
        if (!$oper->loaded()) {
            $oper = $this->pixie->orm->get('operationuser');
        }
        $oper->calc_fund_user_idcalc_fund_user = $cfu->idcalc_fund_user;
        $oper->money = (float) $prp;
        $oper->users_id = $award_global->user->id;
        $oper->save();
    }

    private function get_fsf($faculty,$year) {
        $res = $this->pixie->orm->get('operation')->with('faculty','calcfund')->where('a0.id',$faculty)->where('a1.year',$year)->find();
        if ($res->loaded()) {
            return $res->money;
        } else {
            return null;
        }
    }

    /**
     * отображает скисок факультетов и денги выделенные им
     */
    public function action_list_fund() {
        if(!$this->logged_in())
            return;

        $dir = 'asc';
        $d = $this->request->get('dir');
        if ($d != null && $d == 'desc') {
            $dir = 'desc';
        }

        $sort = $this->request->get('sort');

        $year = $this->request->param('id');
        $stage_id = $this->request->param('stage');
        $awards = null;
        switch ($sort) {
            case 'faculty':
//                $awards = $this->pixie->orm->get('operation')->with('award')->with('award.faculty')->where('a0.year',$year)->where('a0.stage_id',$stage_id)->order_by('a1.name',$dir)->find_all();
                $awards = $this->pixie->orm->get('operation')->with('faculty','calcfund')->where('a1.year',$year)->order_by('a0.name',$dir)->find_all();
                break;
           default :
                $awards = $this->pixie->orm->get('operation')->with('faculty','calcfund')->where('a1.year',$year)->order_by('operation.money',$dir)->find_all();
        }

        $this->view->stage = $stage_id;
        $this->view->awards = $awards;
        $this->view->stages = $this->pixie->orm->get('stage')->find_all();
        $this->view->year = $year;
        $this->view->subview = '/fund/list_fund';
    }

    /**
     * отоброжает список всех сформированных расчетов
     */
    public function action_list_calc() {
        if(!$this->logged_in())
            return;

        $dir = 'asc';
        $d = $this->request->get('dir');
        if ($d != null && $d == 'desc') {
            $dir = 'desc';
        }

        $sort = $this->request->get('sort');

//        $year = $this->request->param('year');
//        $stage_id = $this->request->param('stage');
//        $awards = null;
//        switch ($sort) {
//            case 'faculty':
//                $awards = $this->pixie->orm->get('award')->with('faculty')->where('year',$year)->where('stage_id',$stage_id)->order_by('name',$dir)->find_all();
//                break;
//            default :
//                $awards = $this->pixie->orm->get('award')->with('faculty')->where('year',$year)->where('stage_id',$stage_id)->order_by('awards.money',$dir)->find_all();
//        }
        $calcs = $this->pixie->orm->get('calcfund')->find_all();

//        $this->view->stage = $stage_id;
        $this->view->calcs = $calcs; // в таблицу
//        $this->view->stages = $this->pixie->orm->get('stage')->find_all(); // в комбик
//        $this->view->year = $year;
        $this->view->subview = '/fund/list_calc';
    }
}