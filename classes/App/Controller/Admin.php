<?php
namespace App\Controller;

class Admin extends \App\Page {

    public function action_index(){
        if(!$this->logged_in('admin'))
            return;
        $this->view->super = $this->has_role('super');
        $this->view->message = $this->pixie->auth->user()->email;
        $this->view->subview = '/admin/admin';
    }

    public function action_logout() {
        $this->pixie->auth->logout();
        $this->redirect('/');
    }
}