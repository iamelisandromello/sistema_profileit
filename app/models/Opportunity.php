<?php

class Opportunity extends \HXPHP\System\Model
{

	static function table_name()
	{
		return 'opportunities';
	}

  public function relations()
  {
    return array(
    	'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
    );
  }


}