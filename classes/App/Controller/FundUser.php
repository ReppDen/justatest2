<?php
namespace App\Controller;

class FundUser extends \App\Page {

    public function action_index(){
        if(!$this->logged_in('super'))
            return;
        $this->view->message = $this->pixie->auth->user()->email;
        $this->view->subview = '/admin/admin';
    }

    public function action_logout() {
        $this->pixie->auth->logout();
        $this->redirect('/');
    }

    public function action_calc_fund() {
        if(!$this->logged_in('super'))
            return;

        if ($this->request->method=="POST") {
            $stage = $this->request->post('stage');
            $year = $this->request->post('year');
            $faculty = $this->request->post('faculty');
            $cfu = $this->pixie->orm->get('calcfunduser')->where('year',$year)->where('stage_id',$stage)->find();
            if (!$cfu->loaded()) {
                $cfu = $this->pixie->orm->get('calcfunduser');
            }
            $cfu->year = $year;
            $cfu->date = date("Y-m-d H:i");
            $cfu->stage_id = $stage;

            // выпускайте тяжелую накроманию!
            $awards = $this->pixie->orm->get('awarduser')->with('user.faculty')->where('year',$year)->where('stage_id',$stage)->where('a1.id',$faculty)->find_all();

            $prf = 0.0;
            // считаем сумму баллов преподавателей выбранного факультета
            foreach ($awards as $aw) {
                if ($stage == 1) {
                    $prf +=  $aw->sum;
                } else {
                    $prf +=  $aw->sum*$aw->user->rate;
                }
            }

            // cохраним расчет
            $money = $this->get_fsf($faculty,$stage,$year);
            if ($money == null) {
                $error = "Не сформирован расчет фонда для выбранного этапа и года!<br/>".
                    '<a href="/fund/">Перейти к формированию расчета</a>';
                $this->view->error = $error;
                $this->view->subview = 'error';
                return;
            }
            $cfu->money = $money;
            $cfu->save();

            $awards = $this->pixie->orm->get('awarduser')->with('user.faculty')->where('year',$year)->where('stage_id',$stage)->where('a1.id',$faculty)->find_all();
            foreach ($awards as $aw) {
                $prp = $aw->sum * $aw->user->rate;
                // для первого этапа без ставки
                if ($stage == 1) {
                    $prp = $aw->sum;
                }
                $sp = ($prp / $prf) * $cfu->money;
                $oper = $this->pixie->orm->get('operationuser')->where('calc_fund_user_idcalc_fund_user',$cfu->idcalc_fund_user)->where('awards_users_id',$aw->id)->find();
                if (!$oper->loaded()) {
                    $oper = $this->pixie->orm->get('operationuser');
                }
                $oper->calc_fund_user_idcalc_fund_user = $cfu->idcalc_fund_user;
                $oper->money = (float) $sp;
                $oper->awards_users_id = $aw->id;
                $oper->save();
            }

            $this->view->awards = $awards;
            $this->redirect('/funduser/list_fund/'.$year.'/'.$stage.'/'.$faculty);
        } else {
            $stages = $this->pixie->orm->get('stage')->find_all();
            $faculties = $this->pixie->orm->get('faculty')->find_all();
            $this->view->stages = $stages;
            $this->view->faculties = $faculties;
            $this->view->subview = '/funduser/calc_fund';
        }
    }

    private function get_fsf($faculty,$stage,$year) {
        $res = $this->pixie->orm->get('operation')->with('award')->where('a0.faculties_id',$faculty)->where('a0.stage_id',$stage)->where('a0.year',$year)->find();
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
        if(!$this->logged_in('super'))
            return;

        $dir = 'asc';
        $d = $this->request->get('dir');
        if ($d != null && $d == 'desc') {
            $dir = 'desc';
        }


        $sort = $this->request->get('sort');
        $fac = $this->request->param('faculty');
        $year = $this->request->param('year');
        $stage_id = $this->request->param('stage');
        if ($fac == null) {
            $fac = 1;
        }
        if ($stage_id == null) {
            $stage_id = 1;
        }
        if ($year == null) {
            $year = date("Y");
        }
        $awards = null;
        switch ($sort) {
            case 'fio':
                $awards = $this->pixie->orm->get('operationuser')->with('awarduser','awarduser.user')->where('a0.year',$year)->where('a0.stage_id',$stage_id)->where('a1.faculties_id',$fac)->order_by('a1.fio',$dir)->find_all();
                break;
           default :
               $awards = $this->pixie->orm->get('operationuser')->with('awarduser.user')->where('a0.year',$year)->where('a0.stage_id',$stage_id)->order_by('operation_user.money',$dir)->where('a1.faculties_id',$fac)->find_all();
        }

        $this->view->faculty = $this->pixie->orm->get('faculty')->where('id',$fac)->find();
        $this->view->faculties = $this->pixie->orm->get('faculty')->find_all();
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

    /**
     * отображает скисок сотрудников факультета и баллы выделенные им
     */
    public function action_list_ball() {
        if(!$this->logged_in('super'))
            return;

        $dir = 'asc';
        $d = $this->request->get('dir');
        if ($d != null && $d == 'desc') {
            $dir = 'desc';
        }


        $sort = $this->request->get('sort');
        $fac = $this->request->param('faculty');
        $year = $this->request->param('year');
        $stage_id = $this->request->param('stage');
        if ($fac == null) {
            $fac = 1;
        }
        if ($stage_id == null) {
            $stage_id = 1;
        }
        if ($year == null) {
            $year = date("Y");
        }
        $awards = null;
        switch ($sort) {
            case 'fio':
                $awards = $this->pixie->orm->get('awarduser')->with('user')->where('year',$year)->where('stage_id',$stage_id)->where('a0.faculties_id',$fac)->order_by('a0.fio',$dir)->find_all();
                break;
            default :
                $awards = $this->pixie->orm->get('awarduser')->with('user')->where('year',$year)->where('stage_id',$stage_id)->where('a0.faculties_id',$fac)->find_all();
        }

        $this->view->faculty = $this->pixie->orm->get('faculty')->where('id',$fac)->find();
        $this->view->faculties = $this->pixie->orm->get('faculty')->find_all();
        $this->view->stage = $stage_id;
        $this->view->awards = $awards;
        $this->view->stages = $this->pixie->orm->get('stage')->find_all();
        $this->view->year = $year;
        $this->view->subview = '/funduser/list_ball';
    }
}