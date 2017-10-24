<?php

class Opportunity extends \HXPHP\System\Model
{

	static function table_name()
	{
		return 'opportunities';
	}

	//Relacionamnetos 1:1 entre as tabelas
	static $belongs_to = array(
      array('attibute', 'foreign_key' => 'attribute_id', 'class_name' => 'Attribute'),
      array('profile', 'foreign_key' => 'profile_id', 'class_name' => 'Profile'),
      array('benefit', 'foreign_key' => 'benefit_id', 'class_name' => 'Benefit')
	);

  	public function relations()
   {
   	return array(
    	'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
   );
  }


}