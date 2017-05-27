<?php

class Skill extends \HXPHP\System\Model
{

	static function table_name()
	{
		return 'skills';
	}

	static $has_many = array(
		array('competencies')
	);


}