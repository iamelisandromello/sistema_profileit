<?php

class Parameter extends \HXPHP\System\Model
{
	static function table_name()
	{
		return 'parameters';
	}

  public function relations()
  {
    return array(
    	'weight'=>array(self::BELONGS_TO, 'Weight', 'weight_id'),
    );
  }
  
  
}