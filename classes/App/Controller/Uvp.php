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

    function startsWith($haystack, $needle)
    {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }

    function endsWith($haystack, $needle)
    {
        return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
    }

    public function action_fill_stage()
    {
        if (!$this->logged_in('super'))
            return;

        if ($this->request->method == 'POST') {
            $user_id = $this->request->post('user');
            $year = $this->request->post('year');
            $uvp_stage = $this->request->post('stage');
            $ass_type = $this->pixie->orm->get('user')->where('id', $user_id)->find();

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
                case 1:
                {
                    $lab = true;
                    break;
                }
                case 2:
                {
                    $st_lab = true;
                    break;
                }
                case 3:
                {
                    $methodist = true;
                    break;
                }
                case 4:
                {
                    $specUVP = true;
                    break;
                }
                case 5:
                {
                    $eng = true;
                    break;
                }
                case 6:
                {
                    $doc = true;
                    break;
                }
                case 7:
                {
                    $sec = true;
                    break;
                }

                case 8:
                {
                    $tech = true;
                    break;
                }

                case 9:
                {
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
            $this->view->stage = $this->pixie->orm->get('uvpstage')->where('iduvp_stage', $uvp_stage)->find();
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
            $post_arr = $this->request->post();
            foreach ($post_arr as $key => $val) {
                if ($this->endsWith($key, '_name')) {
                    $text .= $val;
                    $new_key = substr($key,0,strlen($key)-5).'_points';
                    $text .= ' '.$post_arr[$new_key].' баллов<br/>';
                }
                if ($this->endsWith($key, '_points')) {
                    $points += $val;
                }
            }
            $text .= 'Сумма баллов ' . $points . '<br/>';

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

    public function action_list_calc()
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

    public function action_calc_payment() {
        if (!$this->logged_in('super'))
            return;

        if ($this->request->method == 'POST') {
            $sum = $this->request->post('sum');
            $stage = $this->request->post('stage');
            $year = $this->request->post('year');

            $this->uvp_calc_payments($sum,$stage,$year);
        }
        $this->view->stages = $this->pixie->orm->get('uvpstage')->find_all();
        $this->view->subview = 'uvp/calc_payment';
    }

    public function action_list_payment()
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

        $this->view->subview = 'uvp/list_payment';
    }

    private function uvp_calc_payments($sum, $stage, $year)
    {
        // TODO
    }

}