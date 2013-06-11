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

            if ($pbu == 0) {
                $s = 0;
            } else {
                $s = $fsu/$pbu;
            }
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

            $this->calc_user_money2($year, true);

            $this->redirect('/fund/list_fund/'.$year);
        } else {
            $this->view->subview = '/fund/calc_fund';
        }


    }


    /**
     * расчитывает деньги пользователям с учетом изменения в 1 этапе
     */
    public function calc_user_money2($operation_year,$include_changes) {
        $operations = $this->pixie->orm->get('operation')->with('calcfund')->where('a0.year',$operation_year)->find_all();
        foreach ($operations as $operation) {
            // $operation = $this->pixie->orm->get('operation')->where('faculties_id',$fac_id)->with('calcfund')->where('a0.year',$year)->find(); // заменить на переменную цикла
            // найти расчет на текущий год
            $cfu = $this->pixie->orm->get('calcfunduser')->where('year',$operation->calcfund->year)->find();
            if (!$cfu->loaded()) {
                $cfu = $this->pixie->orm->get('calcfunduser');
            }
            $cfu->year = $operation->calcfund->year;
            $cfu->date = date("Y-m-d H:i");
            $cfu->money = $operation->money;
            $cfu->save();

            // расчет есть, считаем приведенный балл факультета через сумму всех ПБ пользователей
            $pbf = 0.0;
            $users = $this->pixie->orm->get('user')->where('faculties_id',$operation->faculties_id)->find_all();
            foreach ($users as $u) {
                // достать все расчеты, в которых учавствует пользователь
                $awards = $this->pixie->orm->get('awarduser')->where('users_id',$u->id)->find_all();
                foreach ($awards as $a) {
                    if ($include_changes) {
                        if ($a->stage_id == 1) {
                            $pbf += $a->sum;
                        } else {
                            $pbf += $a->sum * $u->rate;
                        }
                    } else {
                        $pbf += $a->sum * $u->rate;
                    }
                }
            }

            if ($pbf == 0.0) {
                // нет баллов - нет расчета
                continue;
            }
            // расчитать выплаты пользователям в зависимости от разбалловки
            $users = $this->pixie->orm->get('user')->where('faculties_id',$operation->faculties_id)->find_all();
            foreach ($users as $u) {
                $operation_user = $this->pixie->orm->get('operationuser')->where('calc_fund_user_idcalc_fund_user',$cfu->idcalc_fund_user)->where('users_id',$u->id)->find();
                if (!$operation_user->loaded()) {
                    $operation_user = $this->pixie->orm->get('operationuser');
                }
                $operation_user->calc_fund_user_idcalc_fund_user = $cfu->idcalc_fund_user;
                $operation_user->users_id = $u->id;
                $operation_user->save();

                $user_sum = 0.0;
                $awards = $this->pixie->orm->get('awarduser')->where('users_id',$u->id)->find_all();
                foreach ($awards as $a) {
                    // запишем данные по этапам
                    $op_stage_user = $this->pixie->orm->get('OperationStageUser')->where('operation_user_idoperation_user',$operation_user->idoperation_user)->where('stage_id',$a->stage_id)->find();
                    if (!$op_stage_user->loaded()) {
                        $op_stage_user = $this->pixie->orm->get('OperationStageUser');
                    }

                    $op_stage_user->operation_user_idoperation_user = $operation_user->idoperation_user;
                    $op_stage_user->stage_id = $a->stage_id;

                    if ($include_changes) {
                        if ($a->stage_id == 1) {
                            $op_stage_user->money = (float) $a->sum / $pbf * $cfu->money;
                        } else {
                            $op_stage_user->money = (float) $a->sum * $u->rate / $pbf * $cfu->money;
                        }
                    } else {
                        $op_stage_user->money = (float) $a->sum * $u->rate / $pbf * $cfu->money;
                    }
                    $op_stage_user->save();
                    $user_sum += $op_stage_user->money;

                }

//                $user_money = (float) ($user_sum/$pbf) * $cfu->money;
                $operation_user->money = $user_sum;


                $operation_user->save();
            }
        }
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