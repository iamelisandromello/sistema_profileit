<?php

class Pattern extends \HXPHP\System\Model
{
	static function table_name()
	{
		return 'patterns';
	}

  public function relations()
  {
    return array(
    	'profile'=>array(self::BELONGS_TO, 'Profile', 'profile_id'),
    );
  }
  
 
}