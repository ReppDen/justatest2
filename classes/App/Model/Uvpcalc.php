<?php
namespace App\Model;

//ORM will guess the name of the table
//using the name of the class
class UvpCalc extends \PHPixie\ORM\Model
{

    //Specify the PRIMARY KEY
    public $id_field = 'iduvp_calc';

    //Specify table name
    public $table = 'uvp_calc';

    protected $belongs_to = array(
        'uvp_stage' => array(
            'model' => 'uvpstage',
            'key' => 'uvp_stage_id'
        ),
        'user' => array(
            'model' => 'user',
            'key' => 'users_id'
        )
    );


}