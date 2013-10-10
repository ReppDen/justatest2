<?php
return array(
	'default' => array('(/<controller>(/<action>(/<id>)))', array(
					'controller' => 'Login',
					'action' => 'index'
					)
				),
    'fund' => array('(/<controller>/<action>/<year>/<stage>)', array(
            'controller' => 'Fund',
            'action' => 'index'
        )
    ),
    'funduser' => array('(/<controller>/<action>/<year>/<stage>/<faculty>)', array(
        'controller' => 'Fund',
        'action' => 'index'
        )
    )
);
