<?php
namespace App\Controller;

class FundUser extends \App\Page {

    public function action_index(){
        if(!$this->logged_in('admin'))
            return;
        $this->view->message = $this->pixie->auth->user()->email;
        $this->view->subview = '/admin/admin';
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
        if ($year == null) {
            $year = date("Y");
        }
        $stage_id = $this->request->param('stage');
        $awards = null;
        switch ($sort) {
            case 'fio':
                $awards = $this->pixie->orm->get('operationuser')->with('calcfunduser','user')->where('a0.year',$year)->order_by('a1.fio',$dir)->find_all();
                break;
           default :
               $awards = $this->pixie->orm->get('operationuser')->with('calcfunduser')->where('a0.year',$year)->order_by('operation_user.money',$dir)->find_all();
        }

        $this->view->stage = $stage_id;
        $this->view->awards = $awards;
        $this->view->stages = $this->pixie->orm->get('stage')->find_all();
        $this->view->year = $year;
        $this->view->subview = '/funduser/list_fund';
    }

    /**
     * отоброжает список всех сформированных расчетов
     */
    public function action_list_calc() {
        if(!$this->logged_in())
            return;

        $dir = 'asc';
        $year = $this->request->param('year');
        if ($year == null) {
            $year = date("Y");
        }
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
//                $awards = $this->pixie->orm->get('awarduser')->with('faculty')->where('year',$year)->where('stage_id',$stage_id)->order_by('name',$dir)->find_all();
//                break;
//            default :
//                $awards = $this->pixie->orm->get('awarduser')->with('faculty')->where('year',$year)->where('stage_id',$stage_id)->order_by('awards_users.money',$dir)->find_all();
//        }
        $user = $this->view->user = $this->pixie->auth->user();
        $calcs = $this->pixie->orm->get('calcfunduser')->with('stage')->find_all();
//        $this->view->stage = $stage_id;
        $this->view->calcs = $calcs; // в таблицу
//        $this->view->stages = $this->pixie->orm->get('stage')->find_all(); // в комбик
//        $this->view->year = $year;
        $this->view->subview = '/funduser/list_calc';
    }



//    public function action_calc_fund() {
//        if(!$this->logged_in('admin'))
//            return;
//
//        if ($this->request->method=="POST") {
//            $stage = $this->request->post('stage');
//            $year = $this->request->post('year');
//            $cfu = $this->pixie->orm->get('calcfunduser')->where('year',$year)->where('stage_id',$stage)->find();
//            if (!$cfu->loaded()) {
//                $cfu = $this->pixie->orm->get('calcfunduser');
//            }
//            $faculty = $this->request->post('faculty');
//            $cfu->year = $year;
//            $cfu->date = date("Y-m-d H:i");
//            $cfu->stage_id = $stage;
//
//            // выпускайте тяжелую накроманию!
//            $awards = $this->pixie->orm->get('awarduser')->with('user.faculty')->where('year',$year)->where('stage_id',$stage)->where('a1.id',$faculty)->find_all();
//
//            $prf = 0.0;
//            // считаем сумму баллов преподавателей выбранного факультета
//            foreach ($awards as $aw) {
//                $prf +=  $aw->sum;
//            }
//
//            // cохраним расчет
//            $money = $this->get_fsf($faculty,$stage,$year);
//            if ($money == null) {
//                $error = "Не сформирован расчет фонда для выбранного этапа и года!<br/>".
//                    '<a href="/fund/">Перейти к формированию расчета</a>';
//                $this->view->error = $error;
//                $this->view->subview = 'error';
//                return;
//            }
//            $cfu->money = $money;
//            $cfu->save();
//
//            $awards = $this->pixie->orm->get('awarduser')->with('user.faculty')->where('year',$year)->where('stage_id',$stage)->where('a1.id',$faculty)->find_all();
//            foreach ($awards as $aw) {
//                $prp = ($aw->sum / $prf) * $cfu->money;
//                $oper = $this->pixie->orm->get('operationuser')->where('calc_fund_user_idcalc_fund_user',$cfu->idcalc_fund_user)->where('awards_users_id',$aw->id)->find();
//                if (!$oper->loaded()) {
//                    $oper = $this->pixie->orm->get('operationuser');
//                }
//                $oper->calc_fund_user_idcalc_fund_user = $cfu->idcalc_fund_user;
//                $oper->money = (float) $prp;
//                $oper->awards_users_id = $aw->id;
//                $oper->save();
//            }
//
//            $this->view->awards = $awards;
//            $this->redirect('/funduser/list_fund/'.$year.'/'.$stage);
//        } else {
//            $stages = $this->pixie->orm->get('stage')->find_all();
//            $faculties = $this->pixie->orm->get('faculty')->find_all();
//            $this->view->stages = $stages;
//            $this->view->faculties = $faculties;
//            $this->view->subview = '/funduser/calc_fund';
//        }
//    }
}