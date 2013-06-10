<?php
namespace App\Controller;

class Test extends \App\Page {

    public function action_index(){
        $year = 2013;
        $awards = $this->pixie->orm->get('awarduser')->with('user')->where('year',$year)->find_all();
        $prf = 0.0;
        foreach ($awards as $a) {
            $prf += $a->sum * $a->user->rate;
        }
//        $this->view->calcs = $awards;
        echo $prf;
        $sum  = 0;
        $users = $this->pixie->orm->get('user')->find_all();
        foreach ($users as $u) {
            $_awa = $this->pixie->orm->get('awarduser')->with('user')->where('year',$year)->where('a0.id',$u->id)->find_all();
            $arr_awa = $_awa->as_array();
            if (count($arr_awa) > 0) {
                // есть записи
                $prp_sum = 0.0; // сумма по всем этапам на этот год
                $_awa = $this->pixie->orm->get('awarduser')->with('user')->where('year',$year)->where('a0.id',$u->id)->find_all();
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


                $prp = ($prp_sum * $u->rate / $prf) * $cfu->money;
                $oper = $this->pixie->orm->get('operationuser')->where('calc_fund_user_idcalc_fund_user',$cfu->idcalc_fund_user)->where('users_id',$u->id)->find();
                if (!$oper->loaded()) {
                    $oper = $this->pixie->orm->get('operationuser');
                }
                $oper->calc_fund_user_idcalc_fund_user = $cfu->idcalc_fund_user;
                $oper->money = (float) $prp;
                $oper->users_id = $u->id;
                $oper->save();
            }
        }
        echo $sum. " " .$prf;

//        $this->view->cols = $cols;
        $this->view->subview = '/test/test';
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