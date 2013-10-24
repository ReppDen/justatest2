<?php
namespace App\Controller;

class Ouk extends \App\Page
{
    public function action_index()
    {
        $this->redirect('/ouk/calc_ouk');
    }

    public function action_calc_ouk() {
        if (!$this->logged_in('super'))
            return;

        $stages = $this->pixie->orm->get('stage')->find_all();
        $faculties = $this->pixie->orm->get('oukfaculty')->find_all();

        $all_pps = 0;
        $facult = $this->pixie->orm->get('faculty')->find_all();
        foreach ($facult as $f) {
            $all_pps += $f->nprf;
        }

        $this->view->stages = $stages;
        $this->view->faculties = $faculties;
        $this->view->all = $all_pps;
        $this->view->nprf = $this->pixie->orm->get('oukfaculty')->find()->pr_count;

        $this->view->subview = 'ouk/calc_ouk';
    }

    public function action_fill_ouk()
    {
        if (!$this->logged_in('super'))
            return;

        if ($this->request->method == 'POST') {
            // запишем данные о факе
            $nprf = $this->request->post('nprf');
            $fac = $this->request->post('faculty');

            $f = $this->pixie->orm->get('oukfaculty')->where('idouk_faculty', $fac)->find();
            if ($f->loaded()) {
                $f->pr_count = $nprf;
                $f->save();
            }

            $stage = $this->pixie->orm->get('stage')->where('id', $this->request->post('stage'))->find();
            $year = $this->request->post('year');
            $this->view->stage = $stage;
            $this->view->year = $year;
            $this->view->faculty = $this->request->post('faculty');
            $this->view->subview = 'ouk/fill_ouk';

        } else {
            // нарушитель! алярма!
            $this->redirect('/ouk/');
        }

    }

    public function action_save_stage()
    {

        if (!$this->logged_in('super'))
            return;

        if ($this->request->method == 'POST') {

            $fac = $this->request->post('faculty');
            // сносим старую запись
            // создать запись
            $stage_id = $this->request->post('stage_id');
            $a = $this->pixie->orm->get('oukcalc')->where('ouk_faculty_idouk_faculty', $fac)->where('year', $this->request->post('year'))->where('stage_id', $stage_id)->find();
            if (!$a->loaded()) {
                $a = $this->pixie->orm->get('oukcalc');
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

                    $text .= 'Сумма ' . $points;
                    break;
                case 3:
                    $points += (float)$this->request->post('o4_1');
                    $text .= $this->request->post('o4_1_name') . ' +' . ($this->request->post('o4_1')) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o6_1');
                    $text .= $this->request->post('o6_1_name') . ' +' . ($this->request->post('o1_2')) . ' балла(ов)<br/>';

                    $text .= $this->request->post('o6_2_name');
                    $check = $this->request->post('o6_2');
                    if ($check == "on") {
                        $points += 1.0;
                        $text .= ' +1.0 балла(ов)<br/>';
                    } else {
                        $text .= ' +0 балла(ов)<br/>';
                    }

                    $points += (float)$this->request->post('b1_1');
                    $text .= $this->request->post('b1_1_name') . ' +' . ($this->request->post('o1_3')) . ' балла(ов)<br/>';

                    $text .= 'Сумма ' . $points;
                    break;
            }

            // слоижть в запись данные с формы
            $a->date = date("Y-m-d H:i");
            $a->year = $this->request->post('year');
            $a->sum = $points;
            $a->note = $text;
            // $this->pixie->orm->get('user')->where('id',$this->pixie->auth->user()->id)->find()->faculty->id;
            $a->ouk_faculty_idouk_faculty = $this->request->post('faculty');
            $a->stage_id = $stage_id;

            // сохранить
            $a->save();

            $this->redirect("/ouk/list_ouk/" . $this->request->post('year'));
        } else {
            // нарушитель! алярма!
            $this->redirect('/ouk/');
        }
    }

    public function action_list_ouk()
    {
        if (!$this->logged_in('super'))
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

        if (true) {
            switch ($sort) {
                case 'sum':
                    $this->view->ouk = $this->pixie->orm->get('oukcalc')->where('year', $year)->order_by('sum', $direction)->find_all();
                    break;
                case 'faculty':
                    $this->view->ouk = $this->pixie->orm->get('oukcalc')->with('oukfaculty')->where('year', $year)->order_by("name", $direction)->find_all();
                    break;
                case 'type':
                    $this->view->ouk = $this->pixie->orm->get('oukcalc')->with('stage')->where('year', $year)->order_by("name", $direction)->find_all();
                    break;
                default:
                    $this->view->ouk = $this->pixie->orm->get('oukcalc')->where('year', $year)->order_by('date', $direction)->find_all();
                    break;
            }
        }

        $this->view->subview = 'ouk/list_ouk';
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


