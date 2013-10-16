<?php
namespace App\Controller;

class Award extends \App\Page
{

    public function action_index()
    {
        if (!$this->logged_in())
            return;

        $stages = $this->pixie->orm->get('stage')->find_all();
        $super = $this->has_role('super');
        if ($super) {
            $faculties = $this->pixie->orm->get('faculty')->find_all();
        } else {
            $faculties = $this->pixie->auth->user()->faculty;
        }

        $this->view->super = $super;
        $this->view->stages = $stages;
        $this->view->faculties = $faculties;
        $this->view->nf = $this->pixie->orm->get('faculty')->find()->nf;
        $this->view->nprf = $this->pixie->orm->get('faculty')->find()->nprf;

        $this->view->subview = 'awards/add_award';
    }

    public function action_fill_stage()
    {
        if (!$this->logged_in())
            return;

        if ($this->request->method == 'POST') {
            // запишем данные о факе
            $nf = $this->request->post('nf');
            $nprf = $this->request->post('nprf');
            $fac = $this->request->post('faculty');

            $f = $this->pixie->orm->get('faculty')->where('id', $fac)->find();
            if ($f->loaded()) {
                $f->nf = $nf;
                $f->nprf = $nprf;
                $f->save();
            }

            $stage = $this->pixie->orm->get('stage')->where('id', $this->request->post('stage'))->find();
            $year = $this->request->post('year');
            $this->view->stage = $stage;
            $this->view->year = $year;
            $this->view->faculty = $this->request->post('faculty');
            $this->view->subview = 'awards/fill_award';

        } else {
            // нарушитель! алярма!
            $this->redirect('/award/');
        }

    }

    public function action_save_stage()
    {

        if (!$this->logged_in())
            return;

        if ($this->request->method == 'POST') {

            $fac = $this->request->post('faculty');
            // сносим старую запись
            // создать запись
            $stage_id = $this->request->post('stage_id');
            $a = $this->pixie->orm->get('award')->where('faculties_id', $fac)->where('year', $this->request->post('year'))->where('stage_id', $stage_id)->find();
            if (!$a->loaded()) {
                $a = $this->pixie->orm->get('award');
            }

            // рассчитать баллы
            $points = (float)0.0;
            $text = "";
            switch ($stage_id) {
                case 1:
                    $text .= $this->request->post('o7_1_name');
                    $check = $this->request->post('o7_1');
                    if ($check == "on") {
                        $points += 1.2;
                        $text .= ' +1.2 балла(ов)<br/>';
                    } else {
                        $text .= ' +0 балла(ов)<br/>';
                    }
                    $points += (float)$this->request->post('o7_2') * 1.0;
                    $text .= $this->request->post('o7_2_name') . ' +'
                        . ($this->request->post('o7_2') * 1.0) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o7_2a') * 2.0;
                    $text .= $this->request->post('o7_2a_name') . ' +'
                        . ($this->request->post('o7_2a') * 2.0) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o7_3') * 1.0;
                    $text .= $this->request->post('o7_3_name') . ' +'
                        . ($this->request->post('o7_3') * 1.0) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o7_4') * 1.0;
                    $text .= $this->request->post('o7_4_name') . ' +'
                        . ($this->request->post('o7_4') * 1.0) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o7_5') * 0.1;
                    $text .= $this->request->post('o7_5_name') . ' +'
                        . ($this->request->post('o7_5') * 0.1) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o7_6') * 0.5;
                    $text .= $this->request->post('o7_6_name') . ' +'
                        . ($this->request->post('o7_6') * 0.5) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o7_6a') * 1.0;
                    $text .= $this->request->post('o7_6a_name') . ' +'
                        . ($this->request->post('o7_6a') * 1.0) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o7_6b') * 1.0;
                    $text .= $this->request->post('o7_6b_name') . ' +'
                        . ($this->request->post('o7_6b') * 1.0) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o7_7') * 0.3;
                    $text .= $this->request->post('o7_7_name') . ' +'
                        . ($this->request->post('o7_7') * 0.3) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o7_8') * 0.7;
                    $text .= $this->request->post('o7_8_name') . ' +'
                        . ($this->request->post('o7_8') * 0.7) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o7_9') * 0.1;
                    $text .= $this->request->post('o7_9_name') . ' +'
                        . ($this->request->post('o7_9') * 0.1) . ' балла(ов)<br/>';

                    $text .= 'Сумма ' . $points;
                    break;
                case 2:
                    $points += (float)$this->request->post('o2_1') * 0.25;
                    $text .= $this->request->post('o2_1_name') . ' +' . ($this->request->post('o2_1') * 0.25) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o2_2') * 0.2;
                    $text .= $this->request->post('o2_2_name') . ' +' . ($this->request->post('o2_2') * 0.2) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o3_1');
                    $text .= $this->request->post('o3_1_name') . ' +' . ($this->request->post('o3_1')) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o3_2');
                    $text .= $this->request->post('o3_2_name') . ' +' . ($this->request->post('o3_2')) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o3_3');
                    $text .= $this->request->post('o3_3_name') . ' +' . ($this->request->post('o3_3')) . ' балла(ов)<br/>';

                    $text .= 'Сумма ' . $points;
                    break;
                case 3:
                    $points += (float)$this->request->post('o1_1');
                    $text .= $this->request->post('o1_1_name') . ' +' . ($this->request->post('o1_1')) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o1_2');
                    $text .= $this->request->post('o1_2_name') . ' +' . ($this->request->post('o1_2')) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o1_3');
                    $text .= $this->request->post('o1_3_name') . ' +' . ($this->request->post('o1_3')) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o4_1');
                    $text .= $this->request->post('o4_1_name') . ' +' . ($this->request->post('o4_1')) . ' балла(ов)<br/>';

                    $text .= $this->request->post('o5_1_name');
                    $check = $this->request->post('o5_1');
                    if ($check == "on") {
                        $points += 1.0;
                        $text .= ' + 1.0 балла(ов)<br/>';
                    } else {
                        $text .= ' + 0.0 балла(ов)<br/>';
                    }
                    $points += (float)$this->request->post('o6_1');
                    $text .= $this->request->post('o6_1_name') . ' +' . ($this->request->post('o6_1')) . ' балла(ов)<br/>';
                    $text .= $this->request->post('o6_2_name');
                    $check = $this->request->post('o6_2');
                    if ($check == "on") {
                        $points += 1.0;
                        $text .= ' + 1.0 балла(ов)<br/>';
                    } else {
                        $text .= ' + 0.0 балла(ов)<br/>';
                    }

                    $points += (float)$this->request->post('b1_1');
                    $text .= $this->request->post('b1_1_name') . ' +' . ($this->request->post('b1_1')) . ' балла(ов)<br/>';;
                    $points += (float)$this->request->post('b1_2');
                    $text .= $this->request->post('b1_1a_name');
                    $check = $this->request->post('b1_1a');
                    if ($check == "on") {
                        $points += 0.5;
                        $text .= ' + 0.5 балла(ов)<br/>';
                    } else {
                        $text .= ' + 0.0 балла(ов)<br/>';
                    }
                    $text .= $this->request->post('b1_2_name') . ' +' . ($this->request->post('b1_2')) . ' балла(ов)<br/>';
                    $text .= 'Сумма ' . $points;
                    break;
            }

            // слоижть в запись данные с формы
            $a->date = date("Y-m-d H:i");
            $a->year = $this->request->post('year');
            $a->sum = $points;
            $a->note = $text;
            // $this->pixie->orm->get('user')->where('id',$this->pixie->auth->user()->id)->find()->faculty->id;
            $a->faculties_id = $this->request->post('faculty');
            $a->stage_id = $stage_id;

            // сохранить
            $a->save();

            $this->redirect("/award/list_award/" . $this->request->post('year'));
        } else {
            // нарушитель! алярма!
            $this->redirect('/award/');
        }
    }

    public function action_list_award()
    {
        if (!$this->logged_in())
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
        $isAdmin = $this->has_role('super');
        $this->view->can_delete = $isAdmin;
        $this->view->year = $year;

        if ($isAdmin) {
            switch ($sort) {
                case 'sum':
                    $this->view->awards = $this->pixie->orm->get('award')->where('year', $year)->order_by('sum', $direction)->find_all();
                    break;
                case 'faculty':
                    $this->view->awards = $this->pixie->orm->get('award')->with('faculty')->where('year', $year)->order_by("name", $direction)->find_all();
                    break;
                case 'type':
                    $this->view->awards = $this->pixie->orm->get('award')->with('stage')->where('year', $year)->order_by("name", $direction)->find_all();
                    break;
                default:
                    $this->view->awards = $this->pixie->orm->get('award')->where('year', $year)->order_by('date', $direction)->find_all();
                    break;
            }
        } else {
            $f_id = $this->pixie->orm->get('user')->where('id', $this->pixie->auth->user()->id)->find()->faculty->id;

            switch ($sort) {
                case 'sum':
                    $this->view->awards = $this->pixie->orm->get('award')->where('year', $year)->where("faculties_id", $f_id)->order_by("sum", $direction)->find_all();
                    break;
                case 'faculty':
                    $this->view->awards = $this->pixie->orm->get('award')->with('faculty')->where('year', $year)->where("faculties_id", $f_id)->order_by("name", $direction)->find_all();
                    break;
                case 'type':
                    $this->view->awards = $this->pixie->orm->get('award')->with('stage')->where('year', $year)->where("faculties_id", $f_id)->order_by("name", $direction)->find_all();
                    break;
                default:
                    $this->view->awards = $this->pixie->orm->get('award')->where('year', $year)->where("faculties_id", $f_id)->order_by("date", $direction)->find_all();
                    break;
            }
        }

        $this->view->subview = 'awards/list_award';
    }

    /**
     * просотр текущего расчета
     */
    public function action_watch()
    {
        if (!$this->logged_in())
            return;

        // включим обработку соритровки, если есть параметр
        $id = $this->request->param('id');

        $award = $this->pixie->orm->get('award')->where('id', $id)->find();

        $this->view->award = $award;
        $this->view->subview = 'awards/watch';
    }

}