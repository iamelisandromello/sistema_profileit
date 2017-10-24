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


}