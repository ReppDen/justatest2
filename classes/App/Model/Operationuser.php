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
        'awarduser'=>array(
            'model'=>'awarduser',
            'key'=>'awards_users_id'
        ),
        'calcfunduser'=>array(
            'model'=>'calcfund',
            'key'=>'calc_fund_user_idcalc_fund_user'
        )
    );
}