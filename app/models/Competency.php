<?php

class Competency extends \HXPHP\System\Model
{

	static function table_name()
	{
		return 'competencies';
	}


	static $belongs_to = array(
      array('user', 'foreign_key' => 'user_id', 'class_name' => 'User'),
      array('skill', 'foreign_key' => 'skill_id', 'class_name' => 'Skill'),
	);
}