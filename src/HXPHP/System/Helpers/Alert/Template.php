<?php

namespace HXPHP\System\Helpers\Alert;

class Template
{
	private $template_path = null;
	private $template_file = null;

	public function __construct()
	{
		$this->setTemplatePath(dirname(__FILE__) . DS . 'templates' . DS)
				->setTemplateFile('alert');
	}

	public function setTemplatePath($path)
	{
		$this->template_path = $path;

		return $this;
	}

	public function setTemplateFile($file)
	{
		$this->template_file = $file;

		return $this;
	}

	/**
	 * Método responsável pela obtenção do conteúdo do template
	 * @return html
	 */
	public function get($list = false)
	{
		if ($list)
			$this->setTemplateFile('alert-list');

		$template = $this->template_path . $this->template_file . '.html';

		if (!file_exists($template))
			throw new \Exception("O template para a mensagem nao foi localizado: $template", 1);

		return file_get_contents($template);
	}
}