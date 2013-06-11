<?php
namespace App\Controller;

class FundUser extends \App\Page {

    public function action_index(){
        if(!$this->logged_in('admin'))
            return;
        $this->view->message = $this->pixie->auth->user()->email;
        $this->redirect('/admin/');
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
        $fac = $this->request->param('stage');
        if ($fac == null) {
            $fac = 1;
        }
        if ($year == null) {
            $year = date("Y");
        }
        $awards = null;
        switch ($sort) {
            case 'fio':
                $awards = $this->pixie->orm->get('operationuser')->with('calcfunduser','user')->where('a0.year',$year)->where('a1.faculties_id',$fac)->order_by('a1.fio',$dir)->find_all();
                break;
           default :
               $awards = $this->pixie->orm->get('operationuser')->with('calcfunduser','user')->where('a0.year',$year)->where('a1.faculties_id',$fac)->order_by('operation_user.money',$dir)->find_all();
        }

        $this->view->faculty = $fac;
        $this->view->awards = $awards;
        $this->view->faculties = $this->pixie->orm->get('faculty')->find_all();
        $this->view->year = $year;
        $this->view->subview = '/funduser/list_fund';
    }

    /**
     * отображает скисок этапов и деньги которые получит пользователь за этап
     */
    public function action_list_detail() {
        if(!$this->logged_in())
            return;

        $dir = 'asc';
        $d = $this->request->get('dir');
        if ($d != null && $d == 'desc') {
            $dir = 'desc';
        }

        $sort = $this->request->get('sort');

        $year = $this->request->param('year');
        $user = $this->request->param('stage');
        if ($user == null) {
            $user = 1;
        }
        $awards = null;
        switch ($sort) {
            case 'stage':
                $awards = $this->pixie->orm->get('operationstageuser')->with('operationuser.calcfunduser','stage')->where('a1.year',$year)->where('a0.users_id',$user)->order_by('a2.name',$dir)->find_all();
                break;
            default :
                $awards = $this->pixie->orm->get('operationstageuser')->with('operationuser.calcfunduser')->where('a1.year',$year)->where('a0.users_id',$user)->order_by('operation_stage_user.money',$dir)->find_all();
        }

        $this->view->user = $user;
        $this->view->awards = $awards;
        $this->view->users = $this->pixie->orm->get('user')->find_all();
        $this->view->year = $year;
        $this->view->subview = '/funduser/list_detail';
    }

}