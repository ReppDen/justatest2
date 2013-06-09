<?php
namespace App\Model;

//ORM will guess the name of the table
//using the name of the class
class AwardUser extends \PHPixie\ORM\Model {

    //Specify the PRIMARY KEY
    public $id_field='id';

    //Specify table name
    public $table='awards_users';

    protected $belongs_to = array(
        'faculty'=>array(
            'model'=>'faculty',
            'key'=>'faculties_id'
        ),
        'stage'=>array(
            'model'=>'stage',
            'key'=>'stage_id'
        )
    );
}