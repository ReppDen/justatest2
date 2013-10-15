<?php
namespace App\Model;

//ORM will guess the name of the table
//using the name of the class
class Assisttype extends \PHPixie\ORM\Model {

    //Specify the PRIMARY KEY
    public $id_field='idassist_type';

    //Specify table name
    public $table='assist_type';

}