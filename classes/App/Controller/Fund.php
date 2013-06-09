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
            $awards = $this->pixie->orm->get('award')->where('year',$year)->find_all();
            $pbu = 0.0;
            foreach ($awards as $aw) {
                $nf = $aw->faculty->nf;
                $nshf = $aw->faculty->nprf;
                $kf = $nf/$nu + $nshf/$nshu;
                $pbu += $aw->sum * $kf;
            }

            $awards = $this->pixie->orm->get('award')->where('year',$year)->find_all();
            foreach ($awards as $a) {
                $kf = $a->faculty->nf/$nu + $a->faculty->nprf/$nshu;
                $pbf = $a->sum * $kf;
                $s = $fsu/$pbu;
                $fsf = $pbf * $s;
                $oper = $this->pixie->orm->get('operation')->where('calc_fund_idcalc_fund',$cf->idcalc_fund)->where('faculties_id',$a->faculty->id)->find();
                if (!$oper->loaded()) {
                    $oper = $this->pixie->orm->get('operation');
                }
                $oper->calc_fund_idcalc_fund = $cf->idcalc_fund;
                $oper->money = (float) $fsf;
                $oper->faculties_id = $a->faculty->id;
                $oper->save();
            }
            $this->view->awards = $awards;
            $this->redirect('/fund/list_fund/'.$year);
        } else {
            $this->view->subview = '/fund/calc_fund';
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