<?php
namespace App\Controller;

class Ajax extends \PHPixie\Controller
{

    public function action_index()
    {
        if (!$this->logged_in('admin'))
            return;
    }


    /**
     * Проверяет, есть ли у указанного факультета расчеты
     */
    public function action_check_award()
    {
        if (!$this->logged_in('admin'))
            return;

        if ($this->request->method == 'GET') {
            $id = $this->request->get('id');
            $year = $this->request->get('year');
            $stage_id = $this->request->get('stage');
            if ($id != null && $year != null) {
                $a = $this->pixie->orm->get('award')->where('faculties_id', $id)->where('year', $year)->where('stage_id', $stage_id)->find();
                echo $a->loaded();
            }
        }
    }

    /**
     * Проверяет, есть ли у указанной ОУК расчеты
     */
    public function action_check_ouk()
    {
        if (!$this->logged_in('super'))
            return;

        if ($this->request->method == 'GET') {
            $id = $this->request->get('id');
            $year = $this->request->get('year');
            $stage_id = $this->request->get('stage');
            if ($id != null && $year != null) {
                $a = $this->pixie->orm->get('oukcalc')->where('ouk_faculty_idouk_faculty', $id)->where('year', $year)->where('stage_id', $stage_id)->find();
                echo $a->loaded();
            }
        }
    }


    /**
     * Проверяет, есть ли у указанного пользователя расчеты
     */
    public function action_check_awarduser()
    {
        if (!$this->logged_in('admin'))
            return;

        if ($this->request->method == 'GET') {
            $id = $this->request->get('id');
            $year = $this->request->get('year');
            $stage_id = $this->request->get('stage');
            if ($id != null && $year != null) {
                $a = $this->pixie->orm->get('awarduser')->where('users_id', $id)->where('year', $year)->where('stage_id', $stage_id)->find();
                echo $a->loaded();
            }
        }
    }

    /**
     * Проверяет, есть ли у указанного пользователя расчеты по ОУК
     */
    public function action_check_oukuser()
    {
        if (!$this->logged_in('suuper'))
            return;

        if ($this->request->method == 'GET') {
            $id = $this->request->get('id');
            $year = $this->request->get('year');
            $stage_id = $this->request->get('stage');
            if ($id != null && $year != null) {
                $a = $this->pixie->orm->get('oukcalcuser')->where('users_id', $id)->where('year', $year)->where('stage_id', $stage_id)->find();
                echo $a->loaded();
            }
        }
    }

    /**
     * удаляет указанный рассчет
     */
    public function action_delete_award()
    {
        if (!$this->logged_in('admin'))
            return;

//        Session::set('inActual',true);

        $id = $this->request->param("id");
        if (!$id) {
            return;
        }
        $a = $this->pixie->orm->get('award')->where('id', $id)->find();

        if ($a->loaded()) {
            $d = $a->year;
            $ds = $a->stage_id;
            $a->delete();
            $_SESSION['dirty_year'] = $d;
            $_SESSION['dirty_stage'] = $ds;
        }
    }

    /**
     * удаляет указанный рассчет ОУК
     */
    public function action_delete_ouk()
    {
        if (!$this->logged_in('super'))
            return;

        $id = $this->request->param("id");
        if (!$id) {
            return;
        }
        $a = $this->pixie->orm->get('oukcalc')->where('idouk_calc', $id)->find();

        if ($a->loaded()) {
            $a->delete();
        }
    }

    /**
     * удаляет указанный рассчет для пользователя
     */
    public function action_delete_awarduser()
    {
        if (!$this->logged_in('admin'))
            return;

        $id = $this->request->param("id");
        if (!$id) {
            return;
        }
        $a = $this->pixie->orm->get('awarduser')->where('id', $id)->find();

        if ($a->loaded()) {
            $d = $a->year;
            $ds = $a->stage_id;
            $a->delete();
            $_SESSION['dirty_year'] = $d;
            $_SESSION['dirty_stage'] = $ds;
        }

    }

    /**
     * удаляет указанный рассчет для сотрудника ОУК
     */
    public function action_delete_oukuser()
    {
        if (!$this->logged_in('super'))
            return;

        $id = $this->request->param("id");
        if (!$id) {
            return;
        }
        $a = $this->pixie->orm->get('oukcalcuser')->where('idouk_calc_user', $id)->find();

        if ($a->loaded()) {
            $a->delete();
        }

    }


    /**
     * проверяет коичество расчетов на выбранный факультет, Если их нет то печалька
     */
    public function action_check_funduser_calc_count()
    {
        if (!$this->logged_in('admin'))
            return;
        if ($this->request->method == 'GET') {
            $fac = $this->request->get('id');
            $year = $this->request->get('year');
            $stage_id = $this->request->get('stage');
            $qwe = $this->pixie->orm->get('awarduser')->with('user.faculty')->where('year', $year)->where('stage_id', $stage_id)->where('a1.id', $fac)->find_all()->as_array();

            echo count($qwe);
        }
    }


    /**
     * Достает данные о факультете
     */
    public function action_get_fac_info()
    {
        if (!$this->logged_in('admin'))
            return;

        $id = $this->request->get("id");
        $nf = 0;
        $nprf = 0;
        if ($id != null) {
            $fac = $this->pixie->orm->get('faculty')->where('id', $id)->find();
            $nf = $fac->nf;
            $nprf = $fac->nprf;
        }
        echo json_encode(array(
            'nprf' => $nprf,
            'nf' => $nf
        ));


    }

    /**
     * Достает данные о ОУК
     */
    public function action_get_fac_info_ouk()
    {
        if (!$this->logged_in('super'))
            return;

        $id = $this->request->get("id");
        $nprf = 0;
        if ($id != null) {
            $fac = $this->pixie->orm->get('oukfaculty')->where('idouk_faculty', $id)->find();
            $nprf = $fac->pr_count;
        }
        echo json_encode(array(
            'nprf' => $nprf,
        ));


    }

    protected function logged_in($role = null)
    {
        if ($this->pixie->auth->user() == null) {
            return false;
        }

        if (!$this->pixie->auth->has_role('super') && $role && !$this->pixie->auth->has_role($role)) {
            return false;
        }

        return true;
    }


    public function action_get_prep()
    {
        if ($this->pixie->auth->user() == null) {
            return false;
        }

        if ($this->request->method == 'GET') {
            $id = $this->request->get('id');
            $count = $this->pixie->orm->get('user')->where('faculties_id', $id)->count_all();
            echo $count;
        }

    }

    /**
     * удаляет указанный рассчет
     */
    public function action_delete_uvp()
    {
        if (!$this->logged_in('super'))
            return;

//        Session::set('inActual',true);

        $id = $this->request->param("id");
        if (!$id) {
            return;
        }
        $a = $this->pixie->orm->get('uvpcalc')->where('iduvp_calc', $id)->find();

        if ($a->loaded()) {
            $a->delete();
        }
    }
}
