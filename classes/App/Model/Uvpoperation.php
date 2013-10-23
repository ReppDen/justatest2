<?php
namespace App\Model;

//ORM will guess the name of the table
//using the name of the class
class UvpOperation extends \PHPixie\ORM\Model
{

    //Specify the PRIMARY KEY
    public $id_field = 'iduvp_operation';

    //Specify table name
    public $table = 'uvp_operation';

    protected $belongs_to = array(
        'uvp_stage' => array(
            'model' => 'uvpstage',
            'key' => 'uvp_stage_id'
        )
    );

    protected $has_many = array(
        'uvppayment'=> array (
            'model' => 'uvppayment',
            'key' => 'uvp_operation_id'
        )
    );

}