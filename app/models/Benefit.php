<?php

class Benefit extends \HXPHP\System\Model
{

	static function table_name()
	{
		return 'benefits';
	}

	//Relacionamnetos 1:1 entre as tabelas
  	public function relations()
   {
   	return array(
    		'opportunity'=>array(self::BELONGS_TO, 'Opportunity', 'benefit_id'),
   	);
   }

   public static function cadastrar(array $post)
   {
      $callbackObj = new \stdClass;// Cria classe vazia
      $callbackObj->benefit = null;// Propriedade user da classe null
      $callbackObj->status = false;// Propriedade Status da Classe False
      $callbackObj->errors = array();// Array padrão de erros vazio

      $cadastrar = self::create($post);

      if ($cadastrar->is_valid()) {
         $callbackObj->benefit = $cadastrar;
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