<?php
namespace App\Controller;

class User extends \App\Page
{

    public function action_index()
    {

        if ($this->request->method == 'POST') {
            $u_id = $this->request->post('uid');
            $pas = $this->request->post('password');

            $user = $this->pixie->orm->get('user')->where('id', $u_id)->find();
            $user->fio = $this->request->post('fio');
            $user->email = $this->request->post('email');
            if ($pas != null) {
                $hash = $this->pixie->auth->provider('password')->hash_password($pas);
                $user->password = $hash;
            }

            $user->rate = $this->request->post('rate');
//            $user->faculties_id = $this->request->post('faculty');
            if ($this->request->post('main') == "on") {
                $user->main_job = 1;
            } else {
                $user->main_job = 0;
            }

            $user->save();
            $this->redirect('/?message=Cохранение прошло успешно!');
            return;
        }
        $real = $this->pixie->auth->user();
        $inc = $this->pixie->orm->get('user')->where('id', $this->request->get("id"))->find();
        if ($real != $inc) {
            $this->redirect('/');
            return;
        }
        $this->view->u = $inc;
//        $this->view->faculties = $this->pixie->orm->get('faculty')->find_all();
        $this->view->subview = 'user/user';

    }

    public function action_login()
    {

        if ($this->request->method == 'POST') {
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

    public function action_logout()
    {
        $this->pixie->auth->logout();
        $this->redirect('/');
    }

    public function action_register()
    {
        if ($this->request->method == 'POST') {
            $login = $this->request->post('username');
            $password = $this->request->post('password');
            $fio = $this->request->post('fio');

            // ========= checks ============
            $db_email = $this->pixie->orm->get('user')->where('email', $login)->find();
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
            $user->faculty = $this->pixie->orm->get('faculty')->where('id', $fac)->find();
            $user->save();
            $this->redirect('/');
        }
        $this->view->faculties = $this->pixie->orm->get('faculty')->find_all();
        $this->view->error = null;
        //Include 'login.php' subview
        $this->view->subview = 'register';
    }

}