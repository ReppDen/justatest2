<?php
namespace App\Model;

//ORM will guess the name of the table
//using the name of the class
class Oukcalcuserpay extends \PHPixie\ORM\Model {

    //Specify the PRIMARY KEY
    public $id_field='idouk_calc_user_pay';

    //Specify table name
    public $table='ouk_calc_user_pay';

    protected $belongs_to = array(
        'oukcalcpay'=>array(
            'model'=>'oukcalcpay',
            'key'=>'ouk_calc_pay_idouk_calc_pay'
        ),
        'oukcalcuser' => array(
            'model'=>'oukcalcuser',
            'key'=>'ouk_calc_user_idouk_calc_user'
        )
    );
}