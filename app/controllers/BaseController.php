<?php


/**
 * BaseController
 */
class BaseController
{
	protected $app;
	protected $data;

	public function __construct()
	{
		$this->app = \Slim\Slim::getInstance();
		$this->data = [];
		$this->data['title'] = '';
	}

	/**
	 * Heleper render function
	 */
	protected function render($view, $data = null)
	{
		$this->app->render($view, array_merge($this->data, !empty($data) ? $data : []));
	}
}