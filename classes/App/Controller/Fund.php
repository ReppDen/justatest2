<?php
namespace App\Controller;

class Fund extends \App\Page
{

    public function action_index()
    {
        if (!$this->logged_in('admin'))
            return;
        $this->view->message = $this->pixie->auth->user()->email;
        $this->view->subview = 'admin/admin';
    }

    public function action_logout()
    {
        $this->pixie->auth->logout();
        $this->redirect('/');
    }

    public function action_calc_fund()
    {
        if (!$this->logged_in('super'))
            return;

        if ($this->request->method == "POST") {
            $stage = $this->request->post('stage');
            $year = $this->request->post('year');
            $awards = $this->calc_fund_faculty($year, $stage);
            $this->view->awards = $awards;
            $this->redirect('/fund/list_fund/' . $year . '/' . $stage);
        } else {
            $stages = $this->pixie->orm->get('stage')->find_all();
            $this->view->stages = $stages;
            $this->view->subview = 'fund/calc_fund';
        }
    }

    /**
     * отображает скисок факультетов и денги выделенные им
     */
    public function action_list_fund()
    {
        if (!$this->logged_in())
            return;

        $dir = 'asc';
        $d = $this->request->get('dir');
        if ($d != null && $d == 'desc') {
            $dir = 'desc';
        }

        $sort = $this->request->get('sort');

        $year = $this->request->param('year');
        $stage_id = $this->request->param('stage');
        $awards = null;
        switch ($sort) {
            case 'faculty':
                $awards = $this->pixie->orm->get('operation')->with('award')->with('award.faculty')->where('a0.year', $year)->where('a0.stage_id', $stage_id)->order_by('a1.name', $dir)->find_all();
                break;
            default :
                $awards = $this->pixie->orm->get('operation')->with('award')->with('award.faculty')->where('a0.year', $year)->where('a0.stage_id', $stage_id)->order_by('operation.money', $dir)->find_all();
        }

        $this->view->stage = $stage_id;
        $this->view->awards = $awards;
        $this->view->stages = $this->pixie->orm->get('stage')->find_all();
        $this->view->year = $year;
        $this->view->subview = 'fund/list_fund';
    }

    /**
     * отоброжает список всех сформированных расчетов
     */
    public function action_list_calc()
    {
        if (!$this->logged_in())
            return;

        $dir = 'asc';
        $d = $this->request->get('dir');
        if ($d != null && $d == 'desc') {
            $dir = 'desc';
        }

        $sort = $this->request->get('sort');

//        $year = $this->request->param('year');
//        $stage_id = $this->request->param('stage');
//        $awards = null;
//        switch ($sort) {
//            case 'faculty':
//                $awards = $this->pixie->orm->get('award')->with('faculty')->where('year',$year)->where('stage_id',$stage_id)->order_by('name',$dir)->find_all();
//                break;
//            default :
//                $awards = $this->pixie->orm->get('award')->with('faculty')->where('year',$year)->where('stage_id',$stage_id)->order_by('awards.money',$dir)->find_all();
//        }
        $calcs = $this->pixie->orm->get('calcfund')->find_all();

//        $this->view->stage = $stage_id;
        $this->view->calcs = $calcs; // в таблицу
//        $this->view->stages = $this->pixie->orm->get('stage')->find_all(); // в комбик
//        $this->view->year = $year;
        $this->view->subview = 'fund/list_calc';
    }

    private function calc_fund_faculty($year, $stage)
    {

        $cf = $this->pixie->orm->get('calcfund')->where('year', $year)->where('stage_id', $stage)->find();
        if (!$cf->loaded()) {
            $cf = $this->pixie->orm->get('calcfund');
        }
        $fsu = $this->request->post('fsu');
        $cf->year = $year;
        $cf->fsu = $fsu;
        $cf->date = date("Y-m-d H:i");
        $cf->stage_id = $stage;

        $nu = 0;
        $nshu = 0;

        $faks = $this->pixie->orm->get('faculty')->find_all();
        foreach ($faks as $f) {
            $nu += $f->nf;
            $nshu += $f->nprf;
        }

        // cохраним расчет
        $cf->save();

        // считаем приведенный бал универа
        $awards = $this->pixie->orm->get('award')->where('year', $year)->where('stage_id', $stage)->find_all();
        $pbu = 0.0;
        $t = array();
        foreach ($awards as $aw) {
            $nf = $aw->faculty->nf;
            $nshf = $aw->faculty->nprf;
            $kf = $nf / $nu + $nshf / $nshu;
            $pbu += $aw->sum * $kf;
            $t[] = $aw->id . "|" . $kf;
        }

        $awards = $this->pixie->orm->get('award')->where('year', $year)->where('stage_id', $stage)->find_all();
        foreach ($awards as $a) {
            $kf = $a->faculty->nf / $nu + $a->faculty->nprf / $nshu;
            $pbf = $a->sum * $kf;
            $s = $fsu / $pbu;
            $fsf = $pbf * $s;
            $oper = $this->pixie->orm->get('operation')->where('calc_fund_idcalc_fund', $cf->idcalc_fund)->where('awards_id', $a->id)->find();
            if (!$oper->loaded()) {
                $oper = $this->pixie->orm->get('operation');
            }
            $oper->calc_fund_idcalc_fund = $cf->idcalc_fund;
            $oper->money = (float)$fsf;
            $oper->awards_id = $a->id;
            $oper->save();
        }
        return $awards;
    }

    private function calc_fund_users($year, $stage, $faculty)
    {
        $cfu = $this->pixie->orm->get('calcfunduser')->where('year', $year)->where('stage_id', $stage)->where('faculties_id', $faculty)->find();
        if (!$cfu->loaded()) {
            $cfu = $this->pixie->orm->get('calcfunduser');
        }
        $cfu->year = $year;
        $cfu->date = date("Y-m-d H:i");
        $cfu->stage_id = $stage;

        // выпускайте тяжелую накроманию!
        $awards = $this->pixie->orm->get('awarduser')->with('user.faculty')->where('year', $year)->where('stage_id', $stage)->where('a1.id', $faculty)->find_all();

        $prf = 0.0;
        // считаем сумму баллов преподавателей выбранного факультета
        foreach ($awards as $aw) {
            if ($stage == 1) {
                $prf += $aw->sum;
            } else {
                $prf += $aw->sum * $aw->user->rate;
            }
        }

        // cохраним расчет
        $money = $this->get_fsf($faculty, $stage, $year);
        if ($money == null) {
            $error = "Не сформирован расчет фонда для выбранного этапа и года!<br/>" .
                '<a href="/fund/">Перейти к формированию расчета</a>';
            $this->view->error = $error;
            $this->view->subview = 'error';
            return;
        }
        $cfu->money = $money;
        $cfu->faculties_id = $faculty;
        $cfu->save();

        $awards = $this->pixie->orm->get('awarduser')->with('user.faculty')->where('year', $year)->where('stage_id', $stage)->where('a1.id', $faculty)->find_all();
        foreach ($awards as $aw) {
            // для первого этапа без ставки
            if ($stage == 1) {
                $prp = $aw->sum;
            } else {
                $prp = $aw->sum * $aw->user->rate;
            }
            $sp = ($prp / $prf) * $cfu->money;
            $oper = $this->pixie->orm->get('operationuser')->where('calc_fund_user_idcalc_fund_user', $cfu->idcalc_fund_user)->where('awards_users_id', $aw->id)->find();
            if (!$oper->loaded()) {
                $oper = $this->pixie->orm->get('operationuser');
            }
            $oper->calc_fund_user_idcalc_fund_user = $cfu->idcalc_fund_user;
            $oper->money = (float)$sp;
            $oper->awards_users_id = $aw->id;
            $oper->save();
        }

    }

    private function get_fsf($faculty, $stage, $year)
    {
        $res = $this->pixie->orm->get('operation')->with('award')->where('a0.faculties_id', $faculty)->where('a0.stage_id', $stage)->where('a0.year', $year)->find();
        if ($res->loaded()) {
            return $res->money;
        } else {
            return null;
        }
    }

    public function action_calc_fund_auto()
    {
        if (!$this->logged_in('super'))
            return;

        if ($this->request->method == "POST") {
            $stage = $this->request->post('stage');
            $year = $this->request->post('year');
            $awards = $this->calc_fund_faculty($year, $stage);

            $facs = $this->pixie->orm->get('faculty')->find_all();
            foreach ($facs as $f) {
                $this->calc_fund_users($year, $stage, $f->id);
            }
            $this->view->awards = $awards;
            if (isset($_SESSION['dirty_year']) && $_SESSION['dirty_stage'] && $year == $_SESSION['dirty_year'] && $stage == $_SESSION['dirty_stage']) {
                unset($_SESSION['dirty_year']);
                unset($_SESSION['dirty_stage']);
            }
            $this->redirect('/fund/list_fund/' . $year . '/' . $stage);
        } else {
            $stages = $this->pixie->orm->get('stage')->find_all();
            $this->view->stages = $stages;
            $this->view->subview = 'fund/calc_fund';
        }
    }
}