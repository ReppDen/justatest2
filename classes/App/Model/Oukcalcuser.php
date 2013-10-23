<?php
namespace App\Model;

//ORM will guess the name of the table
//using the name of the class
class Oukcalcuser extends \PHPixie\ORM\Model {

    //Specify the PRIMARY KEY
    public $id_field='idouk_calc_user';

    //Specify table name
    public $table='ouk_calc_user';

    protected $belongs_to = array(
        'stage'=>array(
            'model'=>'stage',
            'key'=>'stage_id'
        ),
        'user'=>array(
            'model'=>'user',
            'key'=>'users_id'
        )
    );
}