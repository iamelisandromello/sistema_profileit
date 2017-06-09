<?php

class Registry extends \HXPHP\System\Model
{
	static function table_name()
	{
		return 'registries';
	}

	//Relacionamnetos 1:1 entre as tabelas
	static $belongs_to = array(
      array('user', 'foreign_key' => 'registry_id', 'class_name' => 'User')
	);

	/**
	* Formata 1234567890 em (12) 3456-7890
	*
	* @param   int    $numero  Numero a ser formatado
	* @return  string
	**/
    public static function formatoTelefone($numero)
    {
        return preg_replace('/(\d{2})(\d{4})(\d*)/', '($1) $2-$3', $numero);
    }

	/**
	* Formata 90050123 em 90.050-123
	*
	* @param   int    $numero  Numero a ser formatado
	* @return  string
	**/
   public static function formatoCep($input)
   {
      return preg_replace('/^(\d{2})(\d{3})(\d{3})$/', '\\1.\\2-\\3', $input);
   }

   public static function cadastrar(array $post)
	{
		$callbackObj = new \stdClass;// Cria classe vazia
		$callbackObj->registry = null;// Propriedade usser da classe null
		$callbackObj->status = false;// Propriedade Status da Classe False
		$callbackObj->errors = array();// Array padrão de erros vazio
       
		$cadastrar = self::create($post);

		if ($cadastrar->is_valid()) {
			$callbackObj->registry = $cadastrar;
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