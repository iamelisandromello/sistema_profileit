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
		
		if ((!is_numeric($competency_id)) || (!is_numeric($level))) {
			array_push($callbackObj->errors, 'Huummm! Inconsistência nos dados informados');
			return $callbackObj;
		}
		
		$competency = self::find($competency_id);
		$owner = $competency->user_id;
		// Verifica se a Competência Pertence ao Usuario
		
		if ($owner != $user_id) {
			array_push($callbackObj->errors, 'Huummm! A Competência em Processo não é de propriedade deste Usuário');
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

	public static function excluir($competency_id, $user_id)
	{
		$callbackObj = new \stdClass;
		$callbackObj->competency = null;
		$callbackObj->status = false;
		$callbackObj->errors = array();
		
		if (!is_numeric($competency_id)) {
			array_push($callbackObj->errors, 'Huummm! Inconsistência nos dados informados');
			return $callbackObj;
		}
		
		$competency = self::find($competency_id);
		// Localiza o Registro da competência BD
		if (is_null($competency)) {
			array_push($callbackObj->errors, 'Huummm! A Competência em Processo não Foi Localizada para este Usuário');
			return $callbackObj;
		}
		
		// Verifica se a Competência Pertence ao Usuario
		$owner = $competency->user_id;		
		if ($owner != $user_id) {
			array_push($callbackObj->errors, 'Huummm! A Competência em Processo não é de propriedade deste Usuário');
			return $callbackObj;
		}

		$excluir = $competency->delete();

		if ($excluir) {
			$callbackObj->competency = $competency;
			$callbackObj->status = true;
			return $callbackObj;
		}

		$errors = $excluir->errors->get_raw_errors();

		foreach ($errors as $field => $message) {
			array_push($callbackObj->errors, $message[0]);
		}

		return $callbackObj;
	}

	public static function adicionar(array $post, $user_id)
	{
		$callbackObj = new \stdClass;
		$callbackObj->user = null;
		$callbackObj->status = false;
		$callbackObj->errors = array();

		$skill = Competency::find_by_user_id($user_id);

		if (is_null($skill)) {
			array_push($callbackObj->errors, 'O Usuário não possui um Perfil de Skill. Contate o administrador');
				return $callbackObj;
		}

		$skill_id = $skill->skill_id;
		$competency = array(
		   'competency' => $post[0],
		   'domain'     => $post[1],
		   'level'      => $post[2],
		   'user_id'    => $user_id,
		   'skill_id'   => $skill_id
		 );

		$skill_competency = self::find_by_competency($competency['competency']);

		if ($skill_competency) {
			array_push($callbackObj->errors, 'Competência já Cadastrada para este Usuário');
				return $callbackObj;
		}  
		    
    	$cadastrar = self::create($competency);

		if ($cadastrar->is_valid()) {
			$callbackObj->user = $cadastrar;
			$callbackObj->status = true;
			return $callbackObj;
		}

		$errors = $cadastrar->errors->get_raw_errors();

		foreach ($errors as $field => $message) {
			array_push($callbackObj->errors, $message[0]);
		}

		return $callbackObj;
	}


}