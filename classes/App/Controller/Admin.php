<?php
namespace App\Controller;

class Admin extends \App\Page
{

    /**
     * главное меню админки
     */
    public function action_index()
    {
        if (!$this->logged_in('admin'))
            return;
        $this->view->super = $this->has_role('super');
        $this->view->message = $this->pixie->auth->user()->email;
        $this->view->subview = 'admin/admin';
    }

    public function action_logout()
    {
        $this->pixie->auth->logout();
        $this->redirect('/');
    }

    /**
     * настройка родей пользователей
     */
    public function action_edit_roles()
    {
        if (!$this->logged_in('super')) {
            return;
        }

        $users = $this->pixie->orm->get('user')->where('dismissed', 0)->order_by('fio','ASC')->find_all();
        $facsults = $this->pixie->orm->get('faculty')->find_all();

        $facs = array();
        foreach ($facsults as $f) {
            $facs[] = array('id' => $f->id, 'name' => $f->name);
        }

        $assists_types = $this->pixie->orm->get('assisttype')->find_all();

        $assists = array();
        $assists[] = array('id' => 0, 'name' => 'Не является УВП');
        foreach ($assists_types as $a) {
            $assists[] = array('id' => $a->idassist_type, 'name' => $a->name);
        }

        $ouk_types = $this->pixie->orm->get('oukfaculty')->find_all();
        $ouk = array();
        $ouk[] = array('id' => 0, 'name' => 'Не числися в ОУК');
        foreach ($ouk_types as $a) {
            $ouk[] = array('id' => $a->idouk_faculty, 'name' => $a->name);
        }


        $this->view->users = $users;
        $this->view->facs = $facs;
        $this->view->assist = $assists;
        $this->view->ouk = $ouk;

        $this->view->subview = 'admin/edit_roles';


    }

}