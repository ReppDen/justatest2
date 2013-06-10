<?php
namespace App\Controller;

class Test extends \App\Page {

    public function action_index(){

        Session::flash('success',"You have added a fairy");
//        $inActual = Session::get('inActual');
        $this->pixie ->inActual = Session::flash('success');
        $this->view->subview = '/test/test';
    }

    public function qwe() {
        $year = 2013;
        $awards = $this->pixie->orm->get('awarduser')->with('user')->where('year',$year)->find_all();
//        $prf = 0.0;
//        foreach ($awards as $a) {
//            $prf += $a->sum * $a->user->rate;
//        }
//        $this->view->calcs = $awards;
//        echo $prf;
        $sum  = 0;
        $users = $this->pixie->orm->get('user')->find_all();
        foreach ($users as $u) {
            $_awa = $this->pixie->orm->get('awarduser')->with('user')->where('year',$year)->where('a0.id',$u->id)->find_all();
            $arr_awa = $_awa->as_array();
            if (count($arr_awa) > 0) {
                // есть записи
                $prp_sum = 0.0; // сумма по всем этапам на этот год
                $_awa = $this->pixie->orm->get('awarduser')->with('user.faculty')->where('year',$year)->where('a1.id',$u->faculty->id)->find_all();
                foreach ($_awa as $_a) {
                    $prp_sum += $_a->sum * $_a->user->rate;
                }
                $sum += $prp_sum;
                // сохранить расчет
                $cfu = $this->pixie->orm->get('calcfunduser')->where('year',$year)->find();
                if (!$cfu->loaded()) {
                    $cfu = $this->pixie->orm->get('calcfunduser');
                }

                $cfu->year = $year;
                $cfu->date = date("Y-m-d H:i");

                $money = $this->get_fsf($u->faculty->id,$year);

                $cfu->money = $money;
                $cfu->save();


                $_awa = $this->pixie->orm->get('awarduser')->with('user')->where('year',$year)->where('a0.id',$u->id)->find_all();
                foreach ($_awa as $_a) {
                    $prp = ($_a->sum * $_a->user->rate / $prp_sum) * $cfu->money;
                    $oper = $this->pixie->orm->get('operationuser')->where('calc_fund_user_idcalc_fund_user',$cfu->idcalc_fund_user)->where('users_id',$_a->users_id)->find();
                    if (!$oper->loaded()) {
                        $oper = $this->pixie->orm->get('operationuser');
                    }
                    $oper->calc_fund_user_idcalc_fund_user = $cfu->idcalc_fund_user;
                    $oper->money = (float) $prp;
                    $oper->users_id = $_a->users_id;
                    $oper->save();
                }

            }
        }
//        echo $sum. " " .$prf;

//        $this->view->cols = $cols;
        $this->view->subview = '/test/test';
    }

    /**
     * расчитывает деньги пользователям
     */
    public function action_user($operation_year) {
        $operations = $this->pixie->orm->get('operation')->with('calcfund')->where('a0.year',$operation_year)->find_all();
        foreach ($operations as $operation) {
            // $operation = $this->pixie->orm->get('operation')->where('faculties_id',$fac_id)->with('calcfund')->where('a0.year',$year)->find(); // заменить на переменную цикла
            // найти расчет на текущий год
            $cfu = $this->pixie->orm->get('calcfunduser')->where('year',$operation->calcfund->year)->find();
            if (!$cfu->loaded()) {
                $cfu = $this->pixie->orm->get('calcfunduser');
            }
            $cfu->year = $operation->calcfund->year;
            $cfu->date = date("Y-m-d H:i");
            $cfu->money = $operation->money;
            $cfu->save();

            // расчет есть, считаем приведенный балл факультета через сумму всех ПБ пользователей
            $pbf = 0.0;
            $users = $this->pixie->orm->get('user')->where('faculties_id',$operation->faculties_id)->find_all();
            foreach ($users as $u) {
                // достать все расчеты, в которых учавствует пользователь
                $awards = $this->pixie->orm->get('awarduser')->where('users_id',$u->id)->find_all();
                foreach ($awards as $a) {
                    $pbf += $a->sum * $u->rate;
                }
            }

            if ($pbf == 0.0) {
                // нет баллов - нет расчета
                continue;
            }
            // расчитать выплаты пользователям в зависимости от разбалловки
            $users = $this->pixie->orm->get('user')->where('faculties_id',$operation->faculties_id)->find_all();
            foreach ($users as $u) {
                $user_sum = 0.0;
                $awards = $this->pixie->orm->get('awarduser')->where('users_id',$u->id)->find_all();
                foreach ($awards as $a) {
                    $user_sum += $a->sum * $u->rate;
                }

                $user_money = ($user_sum/$pbf) * $cfu->money;
                $operation_user = $this->pixie->orm->get('operationuser')->where('calc_fund_user_idcalc_fund_user',$cfu->idcalc_fund_user)->where('users_id',$u->id)->find();
                if (!$operation_user->loaded()) {
                    $operation_user = $this->pixie->orm->get('operationuser');
                }

                $operation_user->money = $user_money;
                $operation_user->calc_fund_user_idcalc_fund_user = $cfu->idcalc_fund_user;
                $operation_user->users_id = $u->id;

                $operation_user->save();
            }
        }
    }

    private function get_fsf($faculty,$year) {
        $res = $this->pixie->orm->get('operation')->with('faculty','calcfund')->where('a0.id',$faculty)->where('a1.year',$year)->find();
        if ($res->loaded()) {
            return $res->money;
        } else {
            return null;
        }
    }

}