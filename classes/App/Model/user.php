<?php
namespace App\Model;

//ORM will guess the name of the table
//using the name of the class
class User extends \PHPixie\ORM\Model {

    //Specify the PRIMARY KEY
    public $id_field='id';

    //Specify table name
    public $table='users';

    protected $belongs_to = array(
        'faculty'=>array(
            'model'=>'faculty',
            'key'=>'faculties_id'
        )
    );
}