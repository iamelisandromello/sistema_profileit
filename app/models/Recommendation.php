<?php

class Recommendation extends \HXPHP\System\Model
{
	static function table_name()
	{
		return 'recommendations';
	}

  public function relations()
   {
      return array(
      	'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
      );
   }

   public static function cadastrar(array $post)
   {
      $callbackObj = new \stdClass;// Cria classe vazia
      $callbackObj->recommendation = null;// Propriedade user da classe null
      $callbackObj->status = false;// Propriedade Status da Classe False
      $callbackObj->errors = array();// Array padrão de erros vazio

      $cadastrar = self::create($post);

      if ($cadastrar->is_valid()) {
         $callbackObj->recommendation = $cadastrar;
         $callbackObj->status = true;
         return $callbackObj;
      }

      $errors = $cadastrar->errors->get_raw_errors();

      foreach ($errors as $field => $message) {
         array_push($callbackObj->errors, $message[0]);
      }

      return $callbackObj;
   }

   public static function atualizar($recommendation_id, $user_id, $status)
   {
      $callbackObj = new \stdClass;
      $callbackObj->recommendation = null;
      $callbackObj->status = false;
      $callbackObj->errors = array();

      if (!is_numeric($recommendation_id)) {
         array_push($callbackObj->errors, 'Huummm! Inconsistência nos dados informados');
         return $callbackObj;
      }

      $recommendation = self::find($recommendation_id);
      $owner = $recommendation->user_id;
      // Verifica se a Recomendação Pertence ao Usuario Logado
      if ($owner != $user_id) {
         array_push($callbackObj->errors, 'Huummm! A Recomendação em Processo não é de propriedade deste Usuário');
         return $callbackObj;
      }

      $recommendation->approved = $status;
      $atualizar = $recommendation->save(false);

      if ($atualizar) {
         $callbackObj->recommendation = $recommendation;
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