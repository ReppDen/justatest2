<?php
namespace App\Model;

//ORM will guess the name of the table
//using the name of the class
class CalcFund extends \PHPixie\ORM\Model {

    //Specify the PRIMARY KEY
    public $id_field='idcalc_fund';

    //Specify table name
    public $table='calc_fund';

}