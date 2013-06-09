<?php
namespace App\Controller;

class Award extends \App\Page {

    public function action_index(){
        if(!$this->logged_in())
            return;

        $stages = $this->pixie->orm->get('stage')->find_all();
        $faculties = $this->pixie->orm->get('faculty')->find_all();
        $this->view->stages = $stages;
        $this->view->faculties =$faculties;
        $this->view->subview = '/awards/add_award';
    }

    public function action_fill_stage() {
        if(!$this->logged_in())
            return;

        if($this->request->method == 'POST'){
            $stage = $this->pixie->orm->get('stage')->where('id',$this->request->post('stage'))->find();
            $year = $this->request->post('year');
            $this->view->stage = $stage;
            $this->view->year = $year;
            $this->view->nf = $this->request->post('nf');
            $this->view->nprf = $this->request->post('nprf');
            $this->view->faculty = $this->request->post('faculty');
            $this->view->overwrite = $this->request->post('overwrite');
            $this->view->subview = '/awards/fill_award';

        } else {
            // нарушитель! алярма!
            $this->redirect('/award/');
        }

    }

    public function action_save_stage() {

        if(!$this->logged_in())
            return;

        if($this->request->method == 'POST'){
            // сносим старую запись
            if ($this->request->post('overwrite')) {
                $old = $this->pixie->orm->get('award')->where('faculties_id',$this->request->post('faculty'))->where('year', $this->request->post('year'))->find();
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
            $a = $this->pixie->orm->get('award');

            // слоижть в запись данные с формы
            $a->date = date("Y-m-d H:i");
            $a->year = $this->request->post('year');
            $a->sum = $points;
            // $this->pixie->orm->get('user')->where('id',$this->pixie->auth->user()->id)->find()->faculty->id;
            $a->faculties_id = $this->request->post('faculty');
            $a->stage_id = $stage_id;
            $a->nf = $this->request->post('nf');
            $a->nprf = $this->request->post('nprf');

            // сохранить
            $a->save();

            $this->redirect("/award/list_award/".$this->request->post('year'));
        } else {
            // нарушитель! алярма!
            $this->redirect('/award/');
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
                    $this->view->awards = $this->pixie->orm->get('award')->where('year',$year)->order_by('sum',$direction)->find_all();
                    break;
                case 'faculty':
                    $this->view->awards = $this->pixie->orm->get('award')->with('faculty')->where('year',$year)->order_by("name",$direction)->find_all();
                    break;
                case 'type':
                    $this->view->awards = $this->pixie->orm->get('award')->with('stage')->where('year',$year)->order_by("name",$direction)->find_all();
                    break;
                default:
                    $this->view->awards = $this->pixie->orm->get('award')->where('year',$year)->order_by('date',$direction)->find_all();
                    break;
            }
        } else {
            $f_id = $this->pixie->orm->get('user')->where('id',$this->pixie->auth->user()->id)->find()->faculty->id;

            switch ($sort) {
                case 'sum':
                    $this->view->awards = $this->pixie->orm->get('award')->where('year', $year)->where("faculties_id", $f_id)->order_by("sum",$direction)->find_all();
                    break;
                case 'faculty':
                    $this->view->awards = $this->pixie->orm->get('award')->with('faculty')->where('year', $year)->where("faculties_id", $f_id)->order_by("name",$direction)->find_all();
                    break;
                case 'type':
                    $this->view->awards = $this->pixie->orm->get('award')->with('stage')->where('year', $year)->where("faculties_id", $f_id)->order_by("name",$direction)->find_all();
                    break;
                default:
                    $this->view->awards = $this->pixie->orm->get('award')->where('year', $year)->where("faculties_id", $f_id)->order_by("date",$direction)->find_all();
                    break;
            }
        }

        $this->view->subview = '/awards/list_award';


    }

}