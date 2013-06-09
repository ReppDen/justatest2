<?php
namespace App\Model;

//ORM will guess the name of the table
//using the name of the class
class Operation extends \PHPixie\ORM\Model {

    //Specify the PRIMARY KEY
    public $id_field='idoperation';

    //Specify table name
    public $table='operation';

    protected $belongs_to = array(
        'faculty'=>array(
            'model'=>'faculty',
            'key'=>'faculties_id'
        ),
        'calcfund'=>array(
            'model'=>'calcfund',
            'key'=>'calc_fund_idcalc_fund'
        )
    );
}