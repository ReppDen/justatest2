<?php
namespace App\Model;

//ORM will guess the name of the table
//using the name of the class
class Oukcalc extends \PHPixie\ORM\Model {

    //Specify the PRIMARY KEY
    public $id_field='idouk_calc';

    //Specify table name
    public $table='ouk_calc';

    protected $belongs_to = array(
        'oukfaculty'=>array(
            'model'=>'oukfaculty',
            'key'=>'ouk_faculty_idouk_faculty'
        ),
        'stage'=>array(
            'model'=>'stage',
            'key'=>'stage_id'
        ),
    );

    protected $has_many = array (
        'oukcalcpay'=>array(
            'model'=>'oukcalcpay',
            'key'=>'ouk_calc_idouk_calc'
        )
    );
}