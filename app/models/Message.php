<?php

class Message extends \HXPHP\System\Model
{
   public function relations()
   {
      return array(
      	'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
      );
   }

   public static function cadastrar(array $post)
   {
      $callbackObj = new \stdClass;// Cria classe vazia
      $callbackObj->mensagem = null;// Propriedade user da classe null
      $callbackObj->status = false;// Propriedade Status da Classe False
      $callbackObj->errors = array();// Array padrão de erros vazio

      $cadastrar = self::create($post);

      if ($cadastrar->is_valid()) {
         $callbackObj->mensagem = $cadastrar;
         $callbackObj->status = true;
         return $callbackObj;
      }

      $errors = $cadastrar->errors->get_raw_errors();

      foreach ($errors as $field => $message) {
         array_push($callbackObj->errors, $message[0]);
      }

      return $callbackObj;
   }

   public static function atualizar($mensagem_id, $user_id, $status)
   {
      $callbackObj = new \stdClass;
      $callbackObj->mensagem = null;
      $callbackObj->status = false;
      $callbackObj->errors = array();

      if (!is_numeric($mensagem_id)) {
         array_push($callbackObj->errors, 'Huummm! Inconsistência nos dados informados');
         return $callbackObj;
      }

      $mensagem = self::find($mensagem_id);
      $owner = $mensagem->user_id;
      // Verifica se a Recomendação Pertence ao Usuario Logado
      if ($owner != $user_id) {
         array_push($callbackObj->errors, 'Huummm! A Mensagem em Processo não é de propriedade deste Usuário');
         return $callbackObj;
      }

      $mensagem->status = $status;
      $atualizar = $mensagem->save(false);

      if ($atualizar) {
         $callbackObj->mensagem = $mensagem;
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