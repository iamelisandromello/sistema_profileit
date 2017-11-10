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
      array('qualification', 'foreign_key' => 'qualification_id', 'class_name' => 'Qualification'),
	);

	public static function cadastrar(array $post, $id_user)
	{
		$skillObj = new \stdClass;// Cria classe vazia
		$skillObj->skill = null;// Propriedade usser da classe null
		$skillObj->status = false;// Propriedade Status da Classe False
		$skillObj->errors = array();// Array padrão de erros vazio
		$callbackObj = new \stdClass;// Cria classe vazia
		$callbackObj->comptency = null;// Propriedade usser da classe null
		$callbackObj->status = false;// Propriedade Status da Classe False
		$callbackObj->errors = array();// Array padrão de erros vazio

		$skill_data = array(
			'description'	=> $post['description']
		);

		$existe = Competency::find_by_user_id($id_user);

		if ($existe) {
			array_push($skillObj->errors, 'Oops! Já existe um Perfil De Competências criado para este usuário');
			return $skillObj;
		}

		$cadastrarSkill = Skill::create($skill_data);
		if ($cadastrarSkill->is_valid()) {
			$skillObj->skill = $cadastrarSkill;
			$skillObj->status = true;
		}
		else {
			$errors = $cadastrarSkill->errors->get_raw_errors();
			foreach ($errors as $field => $message) {
				array_push($skillObj->errors, $message[0]);
			}
			return $skillObj;
		}
		$skill_id = $cadastrarSkill->id;

		$competency_data = array(
			'level'					=> $post['level'],
			'skill_id'				=> $skill_id,
			'user_id'				=> $id_user,
			'qualification_id'	=> $post['qualification_id']
		);

		$cadastrar = self::create($competency_data);

		if ($cadastrar->is_valid()) {
			$callbackObj->competency = $cadastrar;
			$callbackObj->status = true;
			return $callbackObj;
		}

		$errors = $cadastrar->errors->get_raw_errors();

		foreach ($errors as $field => $message) {
			array_push($callbackObj->errors, $message[0]);
		}

		return $callbackObj;
	}

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
		   'qualification_id'	=> $post[0],
		   'level'      			=> $post[1],
		   'user_id'    			=> $user_id,
		   'skill_id'   			=> $skill_id
		 );

		//$skill_competency = self::find_by_competency($competency['competency']);
		$skill_competency = Competency::all(array('conditions' => array('qualification_id = ? AND user_id = ?', $competency['qualification_id'], $user_id)));

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