<?php
return array(
    'default' => array(
        'model' => 'user',

        //Login providers
        'login' => array(
            'password' => array(
                'login_field' => 'email',
                'password_field' => 'password',
                'hash_method' => 'md5'
            )
        ),

        //Role driver configuration
        'roles' => array(
            'driver' => 'field',
            'field' => 'role'
        )
    )
);