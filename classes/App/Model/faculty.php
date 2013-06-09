<?php
namespace App\Model;

//ORM will guess the name of the table
//using the name of the class
class Faculty extends \PHPixie\ORM\Model {

    //Specify the PRIMARY KEY
    public $id_field='id';

    //Specify table name
    public $table='faculties';

    protected $has_many=array(
        'users'=>array(
            'model'=>'user',
            'key'=>'faculties_id'
        ),
        'awards'=>array(
            'model'=>'award',
            'key'=>'faculties_id'
        )
    );
}