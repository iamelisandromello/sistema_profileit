<?php

class Qualification extends \HXPHP\System\Model
{

	//Relacionamnetos 1:n entre as tabelas
	static $has_many = array(
		array('competencies')
	);

}