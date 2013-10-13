<?php
namespace App\Controller;

class UVP extends \App\Page
{

    public function action_index()
    {
        if (!$this->logged_in('super'))
            return;

        $this->view->stages = $this->pixie->orm->get('uvpstage')->find_all();
        $this->view->users = $this->pixie->orm->get('user')->where('assist_type_id', '>', 0)->find_all();
        $this->view->subview = 'uvp/calc_pts';
    }

    public function action_fill_stage()
    {
        if (!$this->logged_in('super'))
            return;

        if ($this->request->method == 'POST') {
            $user_id = $this->request->post('user');
            $year = $this->request->post('year');
            $uvp_stage = $this->request->post('stage');
            $ass_type = $this->pixie->orm->get('user')->where('id',$user_id)->find();

            // roles
            $methodist = null;
            $specUVP = null;
            $masterPO = null;
            $eng = null;
            $st_lab = null;
            $lab = null;
            $doc = null;
            $sec = null;
            $tech = null;
            switch ($ass_type->assist_type_id) {
                case 1: {
                    $lab = true;
                    break;
                }
                case 2: {
                    $st_lab = true;
                    break;
                }
                case 3: {
                    $methodist = true;
                    break;
                }
                case 4: {
                    $specUVP = true;
                    break;
                }
                case 5: {
                    $eng = true;
                    break;
                }
                case 6: {
                    $doc = true;
                    break;
                }
                case 7: {
                    $sec = true;
                    break;
                }

                case 8: {
                    $tech = true;
                    break;
                }

                case 9: {
                    $masterPO = true;
                    break;
                }

            }

            // roles to view
            $this->view->methodist = $methodist;
            $this->view->specUVP = $specUVP;
            $this->view->masterPO = $masterPO;
            $this->view->eng = $eng;
            $this->view->st_lab = $st_lab;
            $this->view->lab = $lab;
            $this->view->doc = $doc;
            $this->view->sec = $sec;
            $this->view->tech = $tech;

            $this->view->year = $year;
            $this->view->user_id = $user_id;
            $this->view->ass_type = $ass_type->assist_type_id;
            $this->view->stage =  $this->pixie->orm->get('uvpstage')->where('iduvp_stage',$uvp_stage)->find();
            $this->view->subview = 'uvp/fill_uvp';

        } else {
            // нарушитель! алярма!
            $this->redirect('/uvp/');
        }

    }

    public function action_save_stage()
    {

        if (!$this->logged_in('super'))
            return;

        if ($this->request->method == 'POST') {
            $stage_id = $this->request->post('stage_id');
            // сносим старую запись
            $calc = $this->pixie->orm->get('uvpcalc')->where('users_id', $this->request->post('user'))->where('year', $this->request->post('year'))->where('uvp_stage_id', $stage_id)->find();
            if (!$calc->loaded()) {
                $calc = $this->pixie->orm->get('uvpcalc');
            }

            // рассчитать баллы
            $text = "";
            $points = (float)0.0;
            /*switch ($stage_id) {
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
            }*/


            // слоижть в запись данные с формы
            $calc->date = date("Y-m-d H:i");
            $calc->year = $this->request->post('year');
            $calc->sum = $points;
            $user_id = $this->request->post('user');
            $calc->users_id = $user_id;
            $calc->uvp_stage_id = $stage_id;
            $calc->note = $text;
            // сохранить
            $calc->save();

            $this->redirect("/uvp/list_calc/" . $this->request->post('year'));
        } else {
            // нарушитель! алярма!
            $this->redirect('/uvp/');
        }
    }

    public function action_list_calc() {
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

        if ($isAdmin) {
            switch ($sort) {
                case 'sum':
                    $this->view->uvp = $this->pixie->orm->get('uvpcalc')->where('year', $year)->order_by('sum', $direction)->find_all();
                    break;
                case 'type':
                    $this->view->uvp = $this->pixie->orm->get('uvpcalc')->with('uvp_stage')->where('year', $year)->order_by("name", $direction)->find_all();
                    break;
                default:
                    $this->view->uvp = $this->pixie->orm->get('uvpcalc')->where('year', $year)->order_by('date', $direction)->find_all();
                    break;
            }
        } else {
            switch ($sort) {
                case 'sum':
                    $this->view->uvp = $this->pixie->orm->get('uvpcalc')->where('year', $year)->order_by("sum", $direction)->find_all();
                    break;
                case 'type':
                    $this->view->uvp = $this->pixie->orm->get('uvpcalc')->with('uvpstage')->where('year', $year)->order_by("name", $direction)->find_all();
                    break;
                default:
                    $this->view->uvp = $this->pixie->orm->get('uvpcalc')->where('year', $year)->order_by("date", $direction)->find_all();
                    break;
            }
        }

        $this->view->subview = 'uvp/list_calc';
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

        $uvp = $this->pixie->orm->get('uvpcalc')->where('iduvp_calc', $id)->find();

        $this->view->uvp = $uvp;
        $this->view->subview = 'uvp/watch';
    }
}