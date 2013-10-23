<?php
namespace App\Model;

//ORM will guess the name of the table
//using the name of the class
class Oukoperation extends \PHPixie\ORM\Model {

    //Specify the PRIMARY KEY
    public $id_field='idouk_operation';

    //Specify table name
    public $table='ouk_operation';

    protected $belongs_to = array(
        'stage'=>array(
            'model'=>'stage',
            'key'=>'stage_id'
        )
    );

    protected $has_many=array(
        'oukcalcpay'=>array(
            'model'=>'oukcalcpay',
            'key'=>'ouk_operation_idtouk_operation'
        )
    );
}