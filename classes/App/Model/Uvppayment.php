<?php
namespace App\Model;

//ORM will guess the name of the table
//using the name of the class
class UvpPayment extends \PHPixie\ORM\Model
{

    //Specify the PRIMARY KEY
    public $id_field = 'iduvp_payment';

    //Specify table name
    public $table = 'uvp_payment';

    protected $belongs_to = array(
        'uvp_operation' => array(
            'model' => 'uvpoperation',
            'key' => 'uvp_operation_id'
        ),
        'user' => array(
            'model' => 'user',
            'key' => 'users_id'
        )
    );


}