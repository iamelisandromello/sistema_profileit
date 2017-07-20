<?php

namespace HXPHP\System\Configs\Modules;

class Auth
{
	public $after_login = null;
	public $after_logout = null;
	public $answer_login = null;

	public function setURLs(
		$after_login,
		$after_logout,
		$answer_login,
		$subfolder = 'default'
	)
	{
		$this->after_login[$subfolder] = $after_login;
		$this->after_logout[$subfolder] = $after_logout;
		$this->answer_login[$subfolder] = $answer_login;

		return $this;
	}
}