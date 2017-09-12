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

  public function listFormations( $user ) {
     $formations_data = array();
     $controle = 0;
     $ctrPos = 0;
     $formacao = 0;
     $statusGra = 0;
     $pos = 0;
     $statusPos = 0;


    foreach ($user->academics as $academic):

      $nivel = $academic->level;
      $status = $academic->status;

      //Verificação Nivel Graduação
      if ($nivel == "Bacharelado") {
        $controle = 1;
      }
      else if ($nivel == "Tecnologo") {
         $controle = 2;
      }
      else if ($nivel == "Tecnico") {
         $controle = 3;
      }
      else if ($nivel == "Medio") {
         $controle = 4;
      }
      else {
         $controle = 5;
      }

      if ($formacao == 0) {
        $formacao = $controle;
        $statusGra = ($controle == 5) ? $statusGra = 1 : $statusGra = $status ;
      }
      else if ( $formacao > $controle ) {
        $formacao = $controle;
        $statusGra = ($controle == 5) ? $statusGra = 1 : $statusGra = $status ;
      }

      //Verificação Nivel Pós
      if ($nivel == "PHD") {
        $ctrPos = 1;
      }
      else if ($nivel == "Doutorado") {
         $ctrPos = 2;
      }
      else if ($nivel == "Mestrado") {
         $ctrPos = 3;
      }
      else if ($nivel == "MBA") {
         $ctrPos = 4;
      }
      else {
         $ctrPos = 5;
      } 

      if ($pos == 0) {
        $pos = $ctrPos;
        $statusPos = ($ctrPos == 5) ? 4 : $status ;
      }
      else if ( $pos > $ctrPos ) {
        $pos = $ctrPos;
        $statusPos = ($ctrPos == 5) ? 4 : $status ;
      }     

    endforeach;
    
    $formations_data[0] = $formacao;
    $formations_data[1] = $statusGra;
    $formations_data[2] = $pos;
    $formations_data[3] = $statusPos;

    return $formations_data;
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