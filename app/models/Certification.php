<?php

class Certification extends \HXPHP\System\Model
{

	static function table_name()
	{
		return 'certifications';
	}

  public function relations()
   {
      return array(
      	'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
      );
   }


	public static function cadastrar(array $post, $id_user)
	{
		$callbackObj = new \stdClass;// Cria classe vazia
		$callbackObj->network = null;// Propriedade usser da classe null
		$callbackObj->status = false;// Propriedade Status da Classe False
		$callbackObj->errors = array();// Array padrão de erros vazio

		$certification    = array(
			'microsoft'		=> $post['microsoft'],
			'linux'			=> $post['linux'],
			'cisco'			=> $post['cisco'],
			'virtualizacao'=> $post['virtualizacao'],
			'pmi' 			=> $post['pmi'],
			'agile' 			=> $post['agile'],
			'itil'			=> $post['itil'],
      	'user_id'      => $id_user
		);

		$cadastrar = self::create($certification);

		if ($cadastrar->is_valid()) {
			$callbackObj->network = $cadastrar;
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