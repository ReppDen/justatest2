<?php
namespace App\Controller;

class Oukcalc extends \App\Page
{
    public function action_index()
    {
        $this->redirect('/ouk_calc/calc_payment');
    }

    private function getAllPps() {
        $all_pps = 0;
        $facult = $this->pixie->orm->get('faculty')->find_all();
        foreach ($facult as $f) {
            $all_pps += $f->nprf;
        }
        return $all_pps;
    }

    public function action_calc_payment() {
        if (!$this->logged_in('super')) {
            return;
        }

        $fond = 0;
        $this->view->all = $this->getAllPps();
        $this->view->fond = $fond;
        $this->view->stages = $this->pixie->orm->get('stage')->find_all();
        $this->view->faculty = $this->pixie->orm->get('oukfaculty')->find_all();
        $this->view->subview = 'ouk_calc/calc_payment';
    }

    public function action_calc_money() {
        if (!$this->logged_in('super')) {
            return;
        }
        if ($this->request->method == 'POST') {

            $year = $this->request->post('year');
            $stage = $this->request->post('stage');
            $money = $this->request->post('money');
            $all = $this->request->post('all_pps'); // все преподы универа
            $pb = array(); //
            //  ========= считаем деньги!============
            $calcs = $this->pixie->orm->get('oukcalc')->where('year',$year)->where('stage_id',$stage)->find_all();
            foreach ($calcs as $c) {
                // посчитать коэф выравнивания
                $k = (float) $c->oukfaculty->pr_count / $all;
                // посчитать приведенный балл каждой кафедры
                $pb[$c->idouk_calc] = (float) $c->sum * $k;
            }
            // посчитать сумму всех приведенных баллов
            $pb_sum = array_sum($pb);
            // посчитать вес однго приведенного балла
            if ($pb_sum == 0.0) {
                $s = 0.0;
            } else {
                $s = (float) $money / $pb_sum;
            }

            // посчитать фонд выплаты кафедре
            $fond_fac = array();
            $calcs = $this->pixie->orm->get('oukcalc')->where('year',$year)->where('stage_id',$stage)->find_all();
            foreach ($calcs as $c) {
                $fond_fac[$c->idouk_calc] = (float) $pb[$c->idouk_calc]  * $s;
            }

            $test = array_sum($fond_fac);
            $epsilon = 0.0000000000000000000000000000000000000000000000000000001;
            if (abs($test - $money) > $epsilon) {
                echo 'error in calcs';
            }

            // сохранить данные
            $ouk_op= $this->pixie->orm->get('oukoperation')->where('stage_id', $stage)->where('year', $year)->find();
            if (!$ouk_op->loaded()) {
                $ouk_op = $this->pixie->orm->get('oukoperation');
            }

            $ouk_op->year = $year;
            $ouk_op->stage_id = $stage;
            $ouk_op->money = $money;
            $ouk_op->date = date("Y-m-d H:i");
            $ouk_op->save();


            $calcs = $this->pixie->orm->get('oukcalc')->where('year',$year)->where('stage_id',$stage)->find_all();
            foreach ($calcs as $c) {
                $ouk_pay= $this->pixie->orm->get('oukcalcpay')->where('ouk_operation_idtouk_operation', $ouk_op->idouk_operation)->where('ouk_calc_idouk_calc', $c->idouk_calc)->find();
                if (!$ouk_pay->loaded()) {
                    $ouk_pay = $this->pixie->orm->get('oukcalcpay');
                }
                $ouk_pay->ouk_operation_idtouk_operation = $ouk_op->idouk_operation;
                $ouk_pay->ouk_calc_idouk_calc = $c->idouk_calc;
                $ouk_pay->money = $fond_fac[$c->idouk_calc];
                $ouk_pay->save();

                // ============================== пользователи ==========================================

                $user_calc = $this->pixie->orm->get('oukcalcuser')->
                    where('year', $year)->
                    where('stage_id',$stage)->
                    with('user')->
                    where('a0.ouk_faculty_idouk_faculty', $ouk_pay->oukcalc->ouk_faculty_idouk_faculty)->
                    find_all(); // все расчеты пользователей, которые относятся к кафедре, этапу и году по которым идет распределение денег
                $user_pb = array();
                foreach ($user_calc as $us) {
                    // посчитать приведенный рейтинг сотрудников
                    $user_pb[$us->idouk_calc_user] = (float) $us->user->rate * $us->sum;
                }
                // посчитать приведенный рейтинг по кафедре (сумма)
                $user_pb_sum = array_sum($user_pb);

                $user_calc = $this->pixie->orm->get('oukcalcuser')->
                    where('year', $year)->
                    where('stage_id',$stage)->
                    with('user')->
                    where('a0.ouk_faculty_idouk_faculty', $ouk_pay->oukcalc->ouk_faculty_idouk_faculty)->
                    find_all(); // все расчеты пользователей, которые относятся к кафедре, этапу и году по которым идет распределение денег
                $user_fond = array();
                foreach ($user_calc as $us) {
                    // посчитать стимулирующую выплату = Сумма(фак) * ПРейт[k] / ПРейт(фак)[k]
                    if ($user_pb_sum == 0.0) {
                        $user_fond[$us->idouk_calc_user] = 0.0;
                    } else {
                        $user_fond[$us->idouk_calc_user] = (float) $ouk_pay->money * $user_pb[$us->idouk_calc_user] / $user_pb_sum;
                    }
                }
                $test2 = array_sum($user_fond);
                if ($test2 != 0 && abs($test2 - $ouk_pay->money) > $epsilon) {
                    echo 'error in calcs users';
                }
                // сохранить данные
                $user_calc = $this->pixie->orm->get('oukcalcuser')->
                    where('year', $year)->
                    where('stage_id',$stage)->
                    with('user')->
                    where('a0.ouk_faculty_idouk_faculty', $ouk_pay->oukcalc->ouk_faculty_idouk_faculty)->
                    find_all(); // все расчеты пользователей, которые относятся к кафедре, этапу и году по которым идет распределение денег
                foreach ($user_calc as $us) {
                    $ouk_user_pay = $this->pixie->orm->get('oukcalcuserpay')->where('ouk_calc_pay_idouk_calc_pay', $ouk_pay->idouk_calc_pay)->where('ouk_calc_user_idouk_calc_user', $us->idouk_calc_user)->find();
                    if (!$ouk_user_pay->loaded()) {
                        $ouk_user_pay = $this->pixie->orm->get('oukcalcuserpay');
                    }
                    $ouk_user_pay->ouk_calc_pay_idouk_calc_pay = $ouk_pay->idouk_calc_pay;
                    $ouk_user_pay->ouk_calc_user_idouk_calc_user = $us->idouk_calc_user;
                    $ouk_user_pay->money = isset($user_fond[$us->idouk_calc_user])? $user_fond[$us->idouk_calc_user] : 0 ;
                    $ouk_user_pay->save();
                }
            }
            //  ========= И.... закончили упражнение!============
            $this->redirect('/oukcalc/list_payment/'.$year.'/'.$stage);
        } else {
            $this->redirect('/oukcalc');
        }
    }

    /**
     * просмотр списка расчетов
     */
    public function action_list_payment() {
        if (!$this->logged_in('super'))
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
        if ($stage_id == null) {
            $stage_id = 1;
        }
        $oper = null;
        switch ($sort) {
            case 'facult':
                $oper = $this->pixie->orm->get('oukcalcpay')->
                    with('oukcalc.oukfaculty')->
                    where('a0.stage_id', $stage_id)->
                    where('a0.year', $year)->

                    order_by('a1.name', $dir)->
                    find_all();
                break;
            default :
                $oper = $this->pixie->orm->get('oukcalc')->
                    where('stage_id', $stage_id)->
                    where('year', $year)->
                    oukcalcpay->
                    order_by('a0.money', $dir)->
                    find_all();
        }

        $this->view->stage = $stage_id;
        $this->view->oper = $oper;
        $this->view->year = $year;
        $this->view->stages = $this->pixie->orm->get('stage')->find_all();
        $this->view->subview = 'ouk_calc/list_payment';

    }

    public function action_list_operation() {
        if (!$this->logged_in('super'))
            return;

        $dir = 'asc';
        $d = $this->request->get('dir');
        if ($d != null && $d == 'desc') {
            $dir = 'desc';
        }

        $sort = $this->request->get('sort');

        $year = $this->request->param('year');
        $stage_id = $this->request->param('stage');
        $oper = null;
        switch ($sort) {
            case 'stage':
                $oper = $this->pixie->orm->get('oukoperation')->
                    with('stage')->
                    order_by('a0.name',$dir)->
                    find_all();
                break;
            case 'date':
                $oper = $this->pixie->orm->get('oukoperation')->
                    order_by('date',$dir)->
                    find_all();
                break;
            case 'sum':
                $oper = $this->pixie->orm->get('oukoperation')->
                    order_by('money',$dir)->
                    find_all();
                break;
            case 'year':
                $oper = $this->pixie->orm->get('oukoperation')->
                    order_by('year',$dir)->
                    find_all();
                break;
            default :
                $oper = $this->pixie->orm->get('oukoperation')->
                    order_by('year',$dir)->
                    find_all();
        }

        $this->view->stage = $stage_id;
        $this->view->oper = $oper; // в таблицу
        $this->view->year = $year;
        $this->view->subview = 'ouk_calc/list_operation';

    }

    public function action_list_payment_user() {
        if (!$this->logged_in('super'))
            return;

        $dir = 'asc';
        $d = $this->request->get('dir');
        if ($d != null && $d == 'desc') {
            $dir = 'desc';
        }

        $sort = $this->request->get('sort');

        $year = $this->request->param('year');
        $faculty_id = $this->request->param('faculty');

        if ($faculty_id == null) {
            $faculty_id = 1;
        }

        if ($year == null) {
            $year = date("Y");
        }
        $stage_id = $this->request->param('stage');
        if ($stage_id == null) {
            $stage_id = 1;
        }
        $oper = null;
        switch ($sort) {
            case 'facult':
                $oper = $this->pixie->orm->get('oukcalcuserpay')->
                    with('oukcalcuser.user.oukfaculty')->
                    where('a1.ouk_faculty_idouk_faculty', $faculty_id)->
                    where('a0.stage_id', $stage_id)->
                    where('a0.year', $year)->
                    order_by('a2.name', $dir)->
                    find_all();
                break;
            default :
                $oper = $this->pixie->orm->get('oukcalcuserpay')->
                    with('oukcalcuser.user')->
                    where('a1.ouk_faculty_idouk_faculty', $faculty_id)->
                    where('a0.stage_id', $stage_id)->
                    where('a0.year', $year)->
                    order_by('ouk_calc_user_pay.money', $dir)->
                    find_all();
        }


        $this->view->stage = $stage_id;
        $this->view->stages = $this->pixie->orm->get('stage')->find_all();
        $this->view->faculties = $this->pixie->orm->get('oukfaculty')->find_all();
        $this->view->faculty_id = $faculty_id;
        $this->view->calcs = $oper; // в таблицу
        $this->view->year = $year;
        $this->view->subview = 'ouk_calc/list_payment_user';
    }

    /**
     * просотр текущего расчета
     */
    public function action_watch()
    {
        if (!$this->logged_in('super'))
            return;

        // включим обработку соритровки, если есть параметр
        $id = $this->request->param('id');

        $ouk = $this->pixie->orm->get('oukcalc')->where('idouk_calc', $id)->find();

        $this->view->ouk = $ouk;
        $this->view->subview = 'ouk/watch';
    }

}


