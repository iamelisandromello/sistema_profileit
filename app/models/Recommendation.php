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

}