<?php
namespace App\Controller;

class AwardUser extends \App\Page
{

    public function action_index()
    {
        if (!$this->logged_in())
            return;

        $current = $this->pixie->auth->user();
        $stages = $this->pixie->orm->get('stage')->find_all();
        $users = null;
        $super = $this->has_role('super');
        if ($super) {
            $users = $this->pixie->orm->get('user')->where('main_job', 1)->find_all();
            $this->view->super = true;
        } else {
            $users = $this->pixie->orm->get('user')->where('main_job', 1)->where('faculties_id', $current->faculty->id)->find_all();
            $this->view->super = false;
        }

        $this->view->stages = $stages;
        $this->view->users = $users;
        $this->view->subview = 'awards_users/add_award';
    }

    public function action_fill_stage()
    {
        if (!$this->logged_in())
            return;

        if ($this->request->method == 'POST') {
            $stage = $this->pixie->orm->get('stage')->where('id', $this->request->post('stage'))->find();
            $year = $this->request->post('year');
            $this->view->stage = $stage;
            $this->view->year = $year;
            $this->view->user = $this->request->post('user');
            $this->view->subview = 'awards_users/fill_award';

        } else {
            // нарушитель! алярма!
            $this->redirect('/awarduser/');
        }

    }

    public function action_save_stage()
    {

        if (!$this->logged_in())
            return;

        if ($this->request->method == 'POST') {
            $stage_id = $this->request->post('stage_id');
            // сносим старую запись
            $a = $this->pixie->orm->get('awarduser')->where('users_id', $this->request->post('user'))->where('year', $this->request->post('year'))->where('stage_id', $stage_id)->find();
            if (!$a->loaded()) {
                $a = $this->pixie->orm->get('awarduser');
            }

            // рассчитать баллы
            $text = "";
            $points = (float)0.0;
            switch ($stage_id) {
                case 1:
                    $points += (float)$this->request->post('o7_2') * 1.0;
                    $text .= $this->request->post('o7_2_name') . ' +' . ($this->request->post('o7_2') * 1.0) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o7_3') * 1.0;
                    $text .= $this->request->post('o7_3_name') . ' +' . ($this->request->post('o7_3') * 1.0) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o7_4') * 1.0;
                    $text .= $this->request->post('o7_4_name') . ' +' . ($this->request->post('o7_4') * 1.0) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o7_5') * 0.1;
                    $text .= $this->request->post('o7_5_name') . ' +' . ($this->request->post('o7_5') * 0.1) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o7_6') * 0.5;
                    $text .= $this->request->post('o7_6_name') . ' +' . ($this->request->post('o7_6') * 0.5) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o7_7') * 0.3;
                    $text .= $this->request->post('o7_7_name') . ' +' . ($this->request->post('o7_7') * 0.3) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o7_8') * 0.5;
                    $text .= $this->request->post('o7_8_name') . ' +' . ($this->request->post('o7_8') * 0.5) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o7_9') * 0.1;
                    $text .= $this->request->post('o7_9_name') . ' +' . ($this->request->post('o7_9') * 0.1) . ' балла(ов)<br/>';
                    $text .= 'Сумма ' . $points;
                    break;
                case 2:
                    $text .= $this->request->post('o2_1_name');
                    if ($this->request->post('o2_1') == "on") {
                        $points += 0.6;
                        $text .= ' +0.6 балла(ов)<br/>';
                    } else {
                        $text .= ' +0.0 балла(ов)<br/>';
                    }

                    $points += (float)$this->request->post('o2_2') * 0.6;
                    $text .= $this->request->post('o2_2_name') . ' +' . ($this->request->post('o2_2') * 0.6) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o2_3');
                    $text .= $this->request->post('o2_3_name') . ' +' . ($this->request->post('o2_3')) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o2_4');
                    $text .= $this->request->post('o2_4_name') . ' +' . ($this->request->post('o2_4')) . ' балла(ов)<br/>';

                    $text .= $this->request->post('o2_5_name');
                    if ($this->request->post('o2_5') == "on") {
                        $points += 1.5;
                        $text .= ' +1.5 балла(ов)<br/>';
                    } else {
                        $text .= ' +0.0 балла(ов)<br/>';
                    }
                    $points += (float)$this->request->post('o3_1');
                    $text .= $this->request->post('o3_1_name') . ' +' . ($this->request->post('o3_1')) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o3_2');
                    $text .= $this->request->post('o3_2_name') . ' +' . ($this->request->post('o3_2')) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o3_3');
                    $text .= $this->request->post('o3_3_name') . ' +' . ($this->request->post('o3_3')) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o3_4');
                    $text .= $this->request->post('o3_4_name') . ' +' . ($this->request->post('o3_4')) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o3_5');
                    $text .= $this->request->post('o3_5_name') . ' +' . ($this->request->post('o3_5')) . ' балла(ов)<br/>';
                    $text .= 'Сумма ' . $points;
                    break;
                case 3:
                    $text .= $this->request->post('o1_1_name');
                    if ($this->request->post('o1_1') == "on") {
                        $points += 0.6;
                        $text .= ' +0.6 балла(ов)<br/>';
                    } else {
                        $text .= ' +0.0 балла(ов)<br/>';
                    }
                    $points += (float)$this->request->post('o4_1');
                    $text .= $this->request->post('o4_1_name') . ' +' . ($this->request->post('o4_1')) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o6_1');
                    $text .= $this->request->post('o6_1_name') . ' +' . ($this->request->post('o6_1')) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o6_2');
                    $text .= $this->request->post('o6_2_name') . ' +' . ($this->request->post('o6_2')) . ' балла(ов)<br/>';

                    $points += (float)$this->request->post('o6_2');
                    $text .= $this->request->post('o6_2_name') . ' +' . ($this->request->post('o6_2')) . ' балла(ов)<br/>';
                    $text .= 'Сумма ' . $points;
                    break;
            }


            // слоижть в запись данные с формы
            $a->date = date("Y-m-d H:i");
            $a->year = $this->request->post('year');
            $a->sum = $points;
            $user_id = $this->request->post('user');
            $a->users_id = $user_id;
            $a->stage_id = $stage_id;
            $a->note = $text;
            // сохранить
            $a->save();

            $this->redirect("/awarduser/list_award/" . $this->request->post('year'));
        } else {
            // нарушитель! алярма!
            $this->redirect('/awarduser/');
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
                    $this->view->awards = $this->pixie->orm->get('awarduser')->where('year', $year)->order_by('sum', $direction)->find_all();
                    break;
                case 'user':
                    $this->view->awards = $this->pixie->orm->get('awarduser')->with('user')->where('year', $year)->order_by("fio", $direction)->find_all();
                    break;
                case 'type':
                    $this->view->awards = $this->pixie->orm->get('awarduser')->with('stage')->where('year', $year)->order_by("name", $direction)->find_all();
                    break;
                default:
                    $this->view->awards = $this->pixie->orm->get('awarduser')->where('year', $year)->order_by('date', $direction)->find_all();
                    break;
            }
        } else {
            $f_id = $this->pixie->orm->get('user')->where('id', $this->pixie->auth->user()->id)->find()->faculty->id;

            switch ($sort) {
                case 'sum':
                    $this->view->awards = $this->pixie->orm->get('awarduser')->where('year', $year)->with('user')->where("a0.faculties_id", $f_id)->order_by("awards_users.sum", $direction)->find_all();
                    break;
                case 'user':
                    $this->view->awards = $this->pixie->orm->get('awarduser')->with('user')->where('year', $year)->where("a0.faculties_id", $f_id)->order_by("fio", $direction)->find_all();
                    break;
                case 'type':
                    $this->view->awards = $this->pixie->orm->get('awarduser')->with('stage', 'user')->where("a1.faculties_id", $f_id)->where('year', $year)->order_by("a0.name", $direction)->find_all();
                    break;
                default:
                    $this->view->awards = $this->pixie->orm->get('awarduser')->where('year', $year)->with('user')->where("a0.faculties_id", $f_id)->order_by("awards_users.date", $direction)->find_all();
                    break;
            }
        }

        $this->view->subview = 'awards_users/list_award';
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

        $award = $this->pixie->orm->get('awarduser')->where('id', $id)->find();

        $this->view->award = $award;
        $this->view->subview = 'awards_users/watch';
    }

}