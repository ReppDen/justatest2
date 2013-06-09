<?php
namespace App\Controller;

class Fund extends \App\Page {

    public function action_index(){
        if(!$this->logged_in('admin'))
            return;
        $this->view->message = $this->pixie->auth->user()->email;
        $this->view->subview = '/admin/admin';
    }

    public function action_logout() {
        $this->pixie->auth->logout();
        $this->redirect('/');
    }

    public function action_calc_fund() {
        if(!$this->logged_in('admin'))
            return;

        if ($this->request->method=="POST") {
            $stage = $this->request->post('stage');
            $year = $this->request->post('year');
            $cf = $this->pixie->orm->get('calcfund')->where('year',$year)->where('stage_id',$stage)->find();
            if (!$cf->loaded()) {
                $cf = $this->pixie->orm->get('calcfund');
            }
            $fsu = $this->request->post('fsu');
            $cf->year = $year;
            $cf->fsu = $fsu;
            $cf->date = date("Y-m-d H:i");
            $cf->stage_id = $stage;

            $nu = 0;
            $nshu = 0;

            // выпускайте тяжелую накроманию!
            $awards = $this->pixie->orm->get('award')->where('year',$year)->where('stage_id',$stage)->find_all();

            // считаем сумму преподователей и студентов
            foreach ($awards as $aw) {
                $nu += $aw->nf;
                $nshu += $aw->nprf;
            }

            // cохраним расчет
            $cf->nu = $nu;
            $cf->npru = $nshu;
            $cf->save();

            // считаем приведенный бал универа
            $awards = $this->pixie->orm->get('award')->where('year',$year)->where('stage_id',$stage)->find_all();
            $pbu = 0.0;
            foreach ($awards as $aw) {
                $nf = $aw->nf;
                $nshf = $aw->nprf;
                $kf = $nf/$nu + $nshf/$nshu;
                $pbu += $aw->sum * $kf;
            }

            $awards = $this->pixie->orm->get('award')->where('year',$year)->where('stage_id',$stage)->find_all();
            foreach ($awards as $a) {
                $kf = $a->nf/$nu + $a->nprf/$nshu;
                $pbf = $a->sum * $kf;
                $s = $fsu/$pbu;
                $fsf = $pbf * $s;
                $a->money = (float) $fsf;
                $a->save();
            }
            $this->view->awards = $awards;
            $this->redirect('/fund/list_fund/'.$year.'/'.$stage);
        } else {
            $stages = $this->pixie->orm->get('stage')->find_all();
            $this->view->stages = $stages;
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

        $year = $this->request->param('year');
        $stage_id = $this->request->param('stage');
        $awards = null;
        switch ($sort) {
            case 'faculty':
                $awards = $this->pixie->orm->get('award')->with('faculty')->where('year',$year)->where('stage_id',$stage_id)->order_by('name',$dir)->find_all();
                break;
           default :
                $awards = $this->pixie->orm->get('award')->with('faculty')->where('year',$year)->where('stage_id',$stage_id)->order_by('awards.money',$dir)->find_all();
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
        $calcs = $this->pixie->orm->get('calcfund')->with('stage')->find_all();

//        $this->view->stage = $stage_id;
        $this->view->calcs = $calcs; // в таблицу
//        $this->view->stages = $this->pixie->orm->get('stage')->find_all(); // в комбик
//        $this->view->year = $year;
        $this->view->subview = '/fund/list_calc';
    }
}