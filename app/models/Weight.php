<?php

class Weight extends \HXPHP\System\Model
{
	static function table_name()
	{
		return 'weights';
	}

  //Relacionamnetos 1:1 entre as tabelas
  static $belongs_to = array(    
    array('parameter', 'foreign_key' => 'weight_id', 'class_name' => 'Parameter')
  );
   
}