<?php
namespace App\Controller;

class AwardUser extends \App\Page {

    public function action_index(){
        if(!$this->logged_in())
            return;

        $stages = $this->pixie->orm->get('stage')->find_all();
        $users = $this->pixie->orm->get('user')->find_all();
        $this->view->stages = $stages;
        $this->view->users =$users;
        $this->view->subview = '/awards_users/add_award';
    }

    public function action_fill_stage() {
        if(!$this->logged_in())
            return;

        if($this->request->method == 'POST'){
            $stage = $this->pixie->orm->get('stage')->where('id',$this->request->post('stage'))->find();
            $year = $this->request->post('year');
            $this->view->stage = $stage;
            $this->view->year = $year;
            $this->view->pr_count = $this->request->post('pr_count');
            $this->view->faculty = $this->request->post('faculty');
            $this->view->overwrite = $this->request->post('overwrite');
            $this->view->subview = '/awards_users/fill_award';

        } else {
            // нарушитель! алярма!
            $this->redirect('/awarduser/');
        }

    }

    public function action_save_stage() {

        if(!$this->logged_in())
            return;

        if($this->request->method == 'POST'){
            // сносим старую запись
            if ($this->request->post('overwrite')) {
                $old = $this->pixie->orm->get('awarduser')->where('faculties_id',$this->request->post('faculty'))->where('year', $this->request->post('year'))->find();
                $old->delete();
            }

            $stage_id = $this->request->post('stage_id');

            // TODO validation
            // рассчитать баллы
            $points = (float) 0.0;
            switch ($stage_id) {
                case 1:
                    $check = $this->request->post('o7_1');
                    if ($check == "on") {
                        $points += 1.2;
                    }
                    $points += (float) $this->request->post('o7_2') * 1.0;
                    $points += (float) $this->request->post('o7_3') * 1.0;
                    $points += (float) $this->request->post('o7_4') * 1.0;
                    $points += (float) $this->request->post('o7_5') * 0.1;
                    $points += (float) $this->request->post('o7_6') * 0.5;
                    $points += (float) $this->request->post('o7_7') * 0.3;
                    $points += (float) $this->request->post('o7_8') * 0.5;
                    $points += (float) $this->request->post('o7_9') * 0.1;
                    break;
                case 2:
                    $points += (float) $this->request->post('o2_1') * 0.25;
                    $points += (float) $this->request->post('o2_2') * 0.2;
                    $points += (float) $this->request->post('o3_1');
                    $points += (float) $this->request->post('o3_2');
                    $points += (float) $this->request->post('o3_3');
                    break;
                case 3:
                    $points += (float) $this->request->post('o1_1');
                    $points += (float) $this->request->post('o1_2');
                    $points += (float) $this->request->post('o1_3');
                    $points += (float) $this->request->post('o4_1');
                    $check = $this->request->post('o5_1');
                    if ($check == "on") {
                        $points += 1.0;
                    }
                    $points += (float) $this->request->post('o6_1');
                    $points += (float) $this->request->post('b1_1');
                    $points += (float) $this->request->post('b1_2');
                    break;
            }


            // создать запись
            $a = $this->pixie->orm->get('awarduser');

            // слоижть в запись данные с формы
            $a->date = date("Y-m-d H:i");
            $a->year = $this->request->post('year');
            $a->sum = $points;
            // $this->pixie->orm->get('user')->where('id',$this->pixie->auth->user()->id)->find()->faculty->id;
            $a->faculties_id = $this->request->post('faculty');
            $a->stage_id = $stage_id;
            $a->pr_count = $this->request->post('pr_count');

            // сохранить
            $a->save();

            $this->redirect("/awarduser/list_award/".$this->request->post('year'));
        } else {
            // нарушитель! алярма!
            $this->redirect('/awarduser/');
        }
    }

    public function action_list_award() {
        if(!$this->logged_in())
            return;

        // включим обработку соритровки, если есть параметр
        $sort = $this->request->get('sort');

        $direction = 'asc';
        $d = $this->request->get('dir');
        if ($d != null && $d == 'desc') {
            $direction = 'desc';
        }
        $year = $this->request->param("id");
        if ($year == null) {
            $year = date("Y");
        }
        $isAdmin = $this->has_role('admin');
        $this->view->can_delete = $isAdmin;
        $this->view->year = $year;

        if ($isAdmin) {
            switch ($sort) {
                case 'sum':
                    $this->view->awards = $this->pixie->orm->get('awarduser')->where('year',$year)->order_by('sum',$direction)->find_all();
                    break;
                case 'faculty':
                    $this->view->awards = $this->pixie->orm->get('awarduser')->with('faculty')->where('year',$year)->order_by("name",$direction)->find_all();
                    break;
                case 'type':
                    $this->view->awards = $this->pixie->orm->get('awarduser')->with('stage')->where('year',$year)->order_by("name",$direction)->find_all();
                    break;
                default:
                    $this->view->awards = $this->pixie->orm->get('awarduser')->where('year',$year)->order_by('date',$direction)->find_all();
                    break;
            }
        } else {
            $f_id = $this->pixie->orm->get('user')->where('id',$this->pixie->auth->user()->id)->find()->faculty->id;

            switch ($sort) {
                case 'sum':
                    $this->view->awards = $this->pixie->orm->get('awarduser')->where('year', $year)->where("faculties_id", $f_id)->order_by("sum",$direction)->find_all();
                    break;
                case 'faculty':
                    $this->view->awards = $this->pixie->orm->get('awarduser')->with('faculty')->where('year', $year)->where("faculties_id", $f_id)->order_by("name",$direction)->find_all();
                    break;
                case 'type':
                    $this->view->awards = $this->pixie->orm->get('awarduser')->with('stage')->where('year', $year)->where("faculties_id", $f_id)->order_by("name",$direction)->find_all();
                    break;
                default:
                    $this->view->awards = $this->pixie->orm->get('awarduser')->where('year', $year)->where("faculties_id", $f_id)->order_by("date",$direction)->find_all();
                    break;
            }
        }

        $this->view->subview = '/awards_users/list_award';


    }

}