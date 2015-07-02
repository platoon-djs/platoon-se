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
	protected function render($view)
	{
		$this->app->render($view, $this->data);
	}
}