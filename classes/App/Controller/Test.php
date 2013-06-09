<?php
namespace App\Controller;

class Test extends \App\Page {

    public function action_index(){
//        $f = $this->pixie->orm->get('faculty')->where('id','1')->find();
//
//        $m = "";
//        $users = $f->users->find_all();
//        foreach ($users as $u) {
//            $m .= $u->email."<br/>";
//        }
//        $this->view->message = $m;
//        $f = $this->pixie->orm->get('lol');
//        $f->qwe = "qweASD";
//        $f.save();
//        $t = $this->pixie->orm->get('user').where('id', $this->pixie->auth->user()->id)->find()->faculty->id;
//        $t =  $this->pixie->orm->get('user')->where('id',$this->pixie->auth->user()->id)->find();
//
//        $this->view->t = $this->pixie->orm->get('award')->where('year', '2013')->where("faculties_id", 1)->find_all();
//        $this->view->subview = '/test/test';
//        $calcs = $this->pixie->orm->get('calcfund')->with('award.stage')->where('year',2013)->where('stage_id',1)->find_all();
//        $calcs =  $this->pixie->db->query('select')->table('calc_fund')
//            ->join(array('stage','s'),array('s.id','calc_fund.idcalc_fund'))
//            ->join(array('awards','a'),array('s.id','a.stage_id'))
//            ->where('calc_fund.year','2013')
//            ->execute();

//        $calcs =  $this->pixie->db->query('select')->table('awards')
//            ->join(array('stage','s'),array('s.id','awards.stage_id'))
//            ->join(array('calc_fund','c'),array('s.id','c.stage_id'))
//            ->where('awards.year','2013')
//            ->execute()->as_array();
        $calcs = $this->pixie->orm->get('user')->where('faculties_id','1')->count_all();
        $this->view->calcs = $calcs;
        $this->view->subview = '/test/test';
    }

}