<?php
namespace App\Model;

//ORM will guess the name of the table
//using the name of the class
class CalcFundUser extends \PHPixie\ORM\Model {

    //Specify the PRIMARY KEY
    public $id_field='idcalc_fund_user';

    //Specify table name
    public $table='calc_fund_user';

    protected $belongs_to = array(
        'stage'=>array(
            'model'=>'stage',
            'key'=>'stage_id'
        )
    );
}