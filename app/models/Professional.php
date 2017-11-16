<?php

class Professional extends \HXPHP\System\Model
{
  public function relations()
   {
      return array(
      	'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
      );
   }

  public static function cadastrar(array $post, $user_id)
  {
    $callbackObj = new \stdClass;// Cria classe vazia
    $callbackObj->professional = null;// Propriedade usser da classe null
    $callbackObj->status = false;// Propriedade Status da Classe False
    $callbackObj->errors = array();// Array padrão de erros vazio

    $dateOut = $post[3];
    if ($post[3] == null ) {
      $dateOut = null;
    }
    else {
      $dateOut = implode("-",array_reverse(explode("/",$dateOut )));
    }
    $dataEntry = implode("-",array_reverse(explode("/",$post[2] )));

    $historic = array(
      'company'     => $post[0],
      'function'    => $post[1],
      'date_entry'  => $dataEntry,
      'date_out'    => $dateOut,
      'assignments' => $post[4],
      'user_id'     => $user_id
    );

    $cadastrar = self::create($historic);

    if ($cadastrar->is_valid()) {
      $callbackObj->professional = $cadastrar;
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
      $callbackObj->professional = null;
      $callbackObj->status = false;
      $callbackObj->errors = array();

      $saida = $post['update_out'];
      if ($post['update_out'] == null ) {
         $saida = null;
      }
      else {
         $saida = implode("-",array_reverse(explode("/",$post['update_out'] )));
      }
      $entrada = implode("-",array_reverse(explode("/",$post['update_entry'] )));

      $professional = self::find($post["upIDProfessional"]);
      $owner = $professional->user_id;
      // Verifica se a Competência Pertence ao Usuario
      if ($owner != $user_id) {
         array_push($callbackObj->errors, 'Huummm! A Experiência em Processo não é de propriedade deste Usuário');
         return $callbackObj;
      }

      $professional->company     = $post["upCompany"];
      $professional->function    = $post["upFunction"];
      $professional->assignments = $post["upAssignments"];
      $professional->date_entry  = $entrada;
      $professional->date_out    = $saida;
      $atualizar = $professional->save(false);

      if ($atualizar) {
         $callbackObj->professional = $professional;
         $callbackObj->status = true;
         return $callbackObj;
      }

      $errors = $atualizar->errors->get_raw_errors();
      foreach ($errors as $field => $message) {
         array_push($callbackObj->errors, $message[0]);
      }
      return $callbackObj;
   }


   public static function excluir($professional_id, $user_id)
   {
      $callbackObj = new \stdClass;
      $callbackObj->professional = null;
      $callbackObj->status = false;
      $callbackObj->errors = array();

      if (!is_numeric($professional_id)) {
         array_push($callbackObj->errors, 'Huummm! Inconsistência nos dados informados');
         return $callbackObj;
      }

      $professional = self::find($professional_id);
      // Localiza o Registro da Experienci Profissional BD
      if (is_null($professional)) {
         array_push($callbackObj->errors, 'Huummm! O Histórico Profissional não Foi Localizado para este Usuário');
         return $callbackObj;
      }

      // Verifica se a Competência Pertence ao Usuario
      $owner = $professional->user_id;
      if ($owner != $user_id) {
         array_push($callbackObj->errors, 'Huummm! O Histórico Profissional em Processo não é de propriedade deste Usuário');
         return $callbackObj;
      }

      $excluir = $professional->delete();
      if ($excluir) {
         $callbackObj->professional = $professional;
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