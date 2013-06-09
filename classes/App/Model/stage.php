<?php
namespace App\Model;

//ORM will guess the name of the table
//using the name of the class
class Stage extends \PHPixie\ORM\Model {

    //Specify the PRIMARY KEY
    public $id_field='id';

    //Specify table name
    public $table='stage';


}