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

	public static function atualizar($competency_id, $level, $user_id)
	{
		$callbackObj = new \stdClass;
		$callbackObj->competency = null;
		$callbackObj->status = false;
		$callbackObj->errors = array();
		$atualizar = null;

		$competency = self::find($competency_id);
		$owner = $competency->user_id;
		$user_id = 28;		
		// Verifica se a Role Default de Usuario existe
		if ($owner != $user_id) {
			array_push($callbackObj->errors, 'Oops! A Competência em Processo não é de propriedade deste Usuário');
			return $callbackObj;
		}

		$competency->level = $level;
		$atualizar = $competency->save(false);

		if ($atualizar) {
			$callbackObj->competency = $competency;
			$callbackObj->status = true;
			return $callbackObj;
		}

		$errors = $atualizar->errors->get_raw_errors();

		foreach ($errors as $field => $message) {
			array_push($callbackObj->errors, $message[0]);
		}

		return $callbackObj;
	}	
}