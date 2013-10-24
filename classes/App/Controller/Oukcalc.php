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

        $this->view->all = $this->getAllPps();
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
                $pb[$c->idouk_calc] = $c->sum * $k;
            }
            // посчитать сумму всех приведенных баллов
            $pb_sum = array_sum($pb);
            // посчитать вес однго приведенного балла
            $s = (float) $money / $pb_sum;
            // посчитать фонд выплаты кафедре
            $fond_fac = array();
            $calcs = $this->pixie->orm->get('oukcalc')->where('year',$year)->where('stage_id',$stage)->find_all();
            foreach ($calcs as $c) {
                $fond_fac[$c->idouk_calc] = $pb[$c->idouk_calc]  * $s;
            }

            $test = array_sum($fond_fac);
            $epsilon = 0.0000000000000000000000000000000000000000000000000000001;
            if (abs($test - $money) < $epsilon) {
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
            }



            // посчитать приведенный рейтинг сотрудников
            $user_calc = $this->pixie->orm->get('oukcalcuser')->where('year', $year)->where('stage_id',$stage)->find_all();
            // посчитать приведенный рейтинг по кафедре (сумма)

            // посчитать стимулирующую выплату = Сумма(фак) * ПРейт[k] / ПРейт(фак)[k]

            //  ========= И.... закончили упражнение!============
        } else {
            $this->redirect('/ouk_calc');
        }
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


