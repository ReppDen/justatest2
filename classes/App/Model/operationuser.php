<?php
namespace App\Model;

//ORM will guess the name of the table
//using the name of the class
class OperationUser extends \PHPixie\ORM\Model {

    //Specify the PRIMARY KEY
    public $id_field='idoperation_user';

    //Specify table name
    public $table='operation_user';

    protected $belongs_to = array(
        'user'=>array(
            'model'=>'user',
            'key'=>'users_id'
        ),
        'calcfunduser'=>array(
            'model'=>'calcfunduser',
            'key'=>'calc_fund_user_idcalc_fund_user'
        )
    );
}