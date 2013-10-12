<?php
namespace App\Controller;

class Overall extends \App\Page {

    public function action_index(){
        if(!$this->logged_in('admin'))
            return;
        $this->view->message = $this->pixie->auth->user()->email;
        $this->redirect("/overall/list/");
    }

    private function get_fsf($faculty,$stage,$year) {
//        $fac = $this->pixie->orm->get('user')->with('faculty')->where('id',$user)->find();
        $res = $this->pixie->orm->get('operation')->with('award')->where('a0.faculties_id',$faculty)->where('a0.stage_id',$stage)->where('a0.year',$year)->find();
        if ($res->loaded()) {
            return $res->money;
        } else {
           return null;
        }
    }

    /**
     * отображает скисок пользователей и денги выделенные им
     */
    public function action_list() {
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
            case 'fio':
                $awards = $this->pixie->orm->get('operationuser')->with('awarduser','awarduser.user')->where('a0.year',$year)->where('a0.stage_id',$stage_id)->order_by('a1.fio',$dir)->find_all();
                break;
           default :
               $awards = $this->pixie->orm->get('operationuser')->with('awarduser')->where('a0.year',$year)->where('a0.stage_id',$stage_id)->order_by('operation_user.money',$dir)->find_all();
        }

        $this->view->stage = $stage_id;
        $this->view->awards = $awards;
        $this->view->stages = $this->pixie->orm->get('stage')->find_all();
        $this->view->year = $year;
        $this->view->subview = 'funduser/list_fund';
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
        $this->view->subview = 'funduser/list_calc';
    }
}