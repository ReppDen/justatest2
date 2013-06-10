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

}