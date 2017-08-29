<?php

class Academic extends \HXPHP\System\Model
{
	static function table_name()
	{
		return 'academics';
	}

  public function relations()
  {
    return array(
    	'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
    );
  }

  public static function cadastrar(array $post, $user_id)
  {
    $callbackObj = new \stdClass;// Cria classe vazia
    $callbackObj->academic = null;// Propriedade user da classe null
    $callbackObj->status = false;// Propriedade Status da Classe False
    $callbackObj->errors = array();// Array padrão de erros vazio

    if (is_null($post[4])){
      $dataConclusao = 'NULL';
    }
    else {
      $dataConclusao = date('Y-m-d',strtotime($post[4]));
    }
 
    $academic = array(
      'institution' => $post[0],
      'local'       => $post[1],
      'course'      => $post[2],
      'level'       => $post[3],
      'date_conclusion' => strtotime($post[4]),
      'status'      => $post[5],
      'user_id'     => $user_id
    );    
       
    $cadastrar = self::create($academic);

    if ($cadastrar->is_valid()) {
      $callbackObj->academic = $cadastrar;
      $callbackObj->status = true;
      return $callbackObj;
    }

    $errors = $cadastrar->errors->get_raw_errors();

    foreach ($errors as $field => $message) {
      array_push($callbackObj->errors, $message[0]);
    }

    return $callbackObj;
  }

  public static function atualizar($post, $user_id)
  {
    $callbackObj = new \stdClass;
    $callbackObj->academic = null;
    $callbackObj->status = false;
    $callbackObj->errors = array();
       
    $academic_id = $post['modalId'];
    $conclusion   = date('Y-m-d',strtotime($post['date_conclusion']));

    $academic = self::find($academic_id);
    $owner = $academic->user_id;
    // Verifica se a Competência Pertence ao Usuario
    
    if ($owner != $user_id) {
      array_push($callbackObj->errors, 'Huummm! A Competência em Processo não é de propriedade deste Usuário');
      return $callbackObj;
    }

    $academic->status = 1;
    $academic->date_conclusion = $conclusion;
    $atualizar = $academic->save(false);

    if ($atualizar) {
      $callbackObj->academic = $academic;
      $callbackObj->status = true;
      return $callbackObj;
    }

    $errors = $atualizar->errors->get_raw_errors();

    foreach ($errors as $field => $message) {
      array_push($callbackObj->errors, $message[0]);
    }

    return $callbackObj;
  }

  public static function excluir($academic_id, $user_id)
  {
    $callbackObj = new \stdClass;
    $callbackObj->academic = null;
    $callbackObj->status = false;
    $callbackObj->errors = array();
    
    if (!is_numeric($academic_id)) {
      array_push($callbackObj->errors, 'Huummm! Inconsistência nos dados informados');
      return $callbackObj;
    }
    
    $academic = self::find($academic_id);
    // Localiza o Registro da competência BD
    if (is_null($academic)) {
      array_push($callbackObj->errors, 'Huummm! O Histórico em Processo não Foi Localizado para este Usuário');
      return $callbackObj;
    }
    
    // Verifica se a Competência Pertence ao Usuario
    $owner = $academic->user_id;    
    if ($owner != $user_id) {
      array_push($callbackObj->errors, 'Huummm! O Histórico em Processo não é de propriedade deste Usuário');
      return $callbackObj;
    }

    $excluir = $academic->delete();

    if ($excluir) {
      $callbackObj->academic = $academic;
      $callbackObj->status = true;
      return $callbackObj;
    }

    $errors = $excluir->errors->get_raw_errors();

    foreach ($errors as $field => $message) {
      array_push($callbackObj->errors, $message[0]);
    }

    return $callbackObj;
  }

}