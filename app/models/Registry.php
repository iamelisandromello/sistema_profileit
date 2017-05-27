<?php

class Registry extends \HXPHP\System\Model
{
	static function table_name()
	{
		return 'registries';
	}

	/**
	* Formata 1234567890 em (12) 3456-7890
	*
	* @param   int    $numero  Numero a ser formatado
	* @return  string
	*/
    public static function formatoTelefone($numero)
    {
        return preg_replace('/(\d{2})(\d{4})(\d*)/', '($1) $2-$3', $numero);
    }

	/**
	* Formata 90050123 em 90.050-123
	*
	* @param   int    $numero  Numero a ser formatado
	* @return  string
	*/
    public static function formatoCep($input)
    {
        return preg_replace('/^(\d{2})(\d{3})(\d{3})$/', '\\1.\\2-\\3', $input);
    }


}