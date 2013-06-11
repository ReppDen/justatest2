<?php
namespace App\Model;

//ORM will guess the name of the table
//using the name of the class
class OperationStageUser extends \PHPixie\ORM\Model {

    //Specify the PRIMARY KEY
    public $id_field='idoperation_stage_user';

    //Specify table name
    public $table='operation_stage_user';

    protected $belongs_to = array(
        'operationuser'=>array(
            'model'=>'operationuser',
            'key'=>'operation_user_idoperation_user'
        ),
        'stage'=>array(
            'model'=>'stage',
            'key'=>'stage_id'
        )
    );
}