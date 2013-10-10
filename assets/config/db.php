<?php

return array(
	'default' => array(
		'user'=>'root',
		'password' => 'admin',
		'driver' => 'PDO',
		
		//'Connection' is required if you use the PDO driver
		'connection'=>'mysql:host=localhost;dbname=awards_old',
		
		// 'db' and 'host' are required if you use Mysql driver
		'db' => 'awards_old',
		'host'=>'localhost'
	)
);
