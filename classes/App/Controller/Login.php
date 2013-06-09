<?php
namespace App\Controller;

class Login extends \App\Page {

    public function action_index(){

        if(!$this->logged_in())
            return;

        $this->view->user = $this->pixie->auth->user();

        //Include 'hello.php' subview
        $this->view->subview = 'home';

    }

    public function action_login() {

        if($this->request->method == 'POST'){
            $login = $this->request->post('username');
            $password = $this->request->post('password');

            //Attempt to login the user using his
            //username and password
            $logged = $this->pixie->auth
                ->provider('password')
                ->login($login, $password);

            $this->view->logged = $logged;
            //On successful login redirect the user to
            //our protected page
            if ($logged) {
                return $this->redirect('/');
            } else {
                $this->view->error = true;
                $this->view->subview = 'login';
                return;
            }

        }
        $this->view->error = false;
        //Include 'login.php' subview
        $this->view->subview = 'login';
    }

    public function action_logout() {
        $this->pixie->auth->logout();
        $this->redirect('/');
    }

    public function action_register() {
        if($this->request->method == 'POST'){
            $login = $this->request->post('username');
            $password = $this->request->post('password');
            $fio = $this->request->post('fio');

            // ========= checks ============
            $db_email = $this->pixie->orm->get('user')->where('email',$login)->find();
            if ($db_email->loaded()) {
                $error = "Пользователь с таким email уже существует";
                $this->view->subview = 'register';
                $this->view->error = $error;
                return;
            }
            // ========= /checks ============

            //Attempt to login the user using his
            //username and password
            $hash = $this->pixie->auth->provider('password')->hash_password($password);

            $fac = $this->request->post("faculty");
            $user = $this->pixie->orm->get('user');
            $user->email = $login;
            $user->password = $hash;
            $user->fio = $fio;
            $user->faculty = $this->pixie->orm->get('faculty')->where('id',$fac)->find();
            // FIXME
            $user->main_job = 1;
            $user->rate = 1.0;

            $user->dismissed = 0;
            $user->save();
            $this->redirect('/');
        }
        $this->view->faculties = $this->pixie->orm->get('faculty')->find_all();
        $this->view->error = null;
        //Include 'login.php' subview
        $this->view->subview = 'register';
    }

}