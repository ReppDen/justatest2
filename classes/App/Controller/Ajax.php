<?php
namespace App\Controller;

class Ajax extends \PHPixie\Controller {

    public function action_index(){
        if(!$this->logged_in('admin'))
            return;
    }


    /**
     * Проверяет, есть ли у указанного факультета расчеты
     */
    public function action_check_award() {
        if(!$this->logged_in('admin'))
            return;

        if ($this->request->method == 'GET'){
            $id = $this->request->get('id');
            $year = $this->request->get('year');
            $stage_id = $this->request->get('stage');
            if ($id != null && $year != null) {
                $a = $this->pixie->orm->get('award')->where('faculties_id',$id)->where('year', $year)->where('stage_id', $stage_id)->find();
                echo $a->loaded();
            }
        }
    }


    /**
     * Проверяет, есть ли у указанного пользователя расчеты
     */
    public function action_check_awarduser() {
        if(!$this->logged_in('admin'))
            return;

        if ($this->request->method == 'GET'){
            $id = $this->request->get('id');
            $year = $this->request->get('year');
            $stage_id = $this->request->get('stage');
            if ($id != null && $year != null) {
                $a = $this->pixie->orm->get('awarduser')->where('users_id',$id)->where('year', $year)->where('stage_id', $stage_id)->find();
                echo $a->loaded();
            }
        }
    }

    /**
     * удаляет указанный рассчет
     */
    public function action_delete_award() {
        if(!$this->logged_in('admin'))
            return;

        $id = $this->request->param("id");
        if (!$id) {
            return;
        }
        $a = $this->pixie->orm->get('award')->where('id',$id)->find();

        $a->delete();
    }

    /**
     * удаляет указанный рассчет для пользователя
     */
    public function action_delete_awarduser() {
        if(!$this->logged_in('admin'))
            return;

        $id = $this->request->param("id");
        if (!$id) {
            return;
        }
        $a = $this->pixie->orm->get('awarduser')->where('id',$id)->find();

        $a->delete();
    }

    /**
     * проверяет коичество расчетов на выбранный факультет, Если их нет то печалька
     */
    public function action_check_funduser_calc_count() {
        if(!$this->logged_in('admin'))
            return;
        if ($this->request->method == 'GET'){
            $fac = $this->request->get('id');
            $year = $this->request->get('year');
            $stage_id = $this->request->get('stage');
            $qwe = $this->pixie->orm->get('awarduser')->with('user.faculty')->where('year',$year)->where('stage_id',$stage_id)->where('a1.id',$fac)->find_all()->as_array();

            echo count($qwe);
        }
    }


    protected function logged_in($role = null){
        if($this->pixie->auth->user() == null){
            return false;
        }

        if($role && !$this->pixie->auth->has_role($role)){
            return false;
        }

        return true;
    }


    public function action_get_prep() {
        if($this->pixie->auth->user() == null){
            return false;
        }

        if ($this->request->method == 'GET'){
            $id = $this->request->get('id');
            $count = $this->pixie->orm->get('user')->where('faculties_id',$id)->count_all();
            echo $count;
        }

    }
}