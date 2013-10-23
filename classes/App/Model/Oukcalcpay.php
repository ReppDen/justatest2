<?php
namespace App\Model;

//ORM will guess the name of the table
//using the name of the class
class Oukcalcpay extends \PHPixie\ORM\Model {

    //Specify the PRIMARY KEY
    public $id_field='idouk_calc_pay';

    //Specify table name
    public $table='ouk_calc_pay';

    protected $belongs_to = array(
        'ouk_operation'=>array(
            'model'=>'oukoperation',
            'key'=>'ouk_operation_idtouk_operation'
        ),
        'ouk_calc'=>array(
            'model'=>'oukcalc',
            'key'=>'ouk_calc_idouk_calc'
        )
    );
    protected $has_many=array(
        'oukcalcuserpay'=>array(
            'model'=>'ouk_calc_user_pay',
            'key'=>'ouk_calc_pay_idouk_calc_pay'
        )
    );
}