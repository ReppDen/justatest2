<?php
namespace App\Model;

//ORM will guess the name of the table
//using the name of the class
class Oukfaculty extends \PHPixie\ORM\Model {

    //Specify the PRIMARY KEY
    public $id_field='idouk_faculty';

    //Specify table name
    public $table='ouk_faculty';

    protected $has_many=array(
        'users'=>array(
            'model'=>'user',
            'key'=>'ouk_faculty_idouk_faculty'
        ),
        'oukcalc'=>array(
            'model'=>'oukcalc',
            'key'=>'ouk_faculty_idouk_faculty'
        )
    );

}