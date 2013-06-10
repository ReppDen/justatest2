<?php

namespace App;

/**
 * Pixie dependency container
 *
 * @property-read \PHPixie\DB $db Database module
 * @property-read \PHPixie\ORM $orm ORM module
 */
class Pixie extends \PHPixie\Pixie {
	protected $modules = array(
		'db' => '\PHPixie\DB',
		'orm' => '\PHPixie\ORM',
        'auth' => '\PHPixie\Auth'
	);

	protected function after_bootstrap(){
        $this->debug->display_errors = true;
	}
}
