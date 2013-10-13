<?php
namespace App\Model;

//ORM will guess the name of the table
//using the name of the class
class Uvpstage extends \PHPixie\ORM\Model {

    //Specify the PRIMARY KEY
    public $id_field='iduvp_stage';

    //Specify table name
    public $table='uvp_stage';


}