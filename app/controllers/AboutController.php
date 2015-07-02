<?php


/**
 * AboutController
 */
class AboutController extends BaseController
{

	public function __construct()
	{
		parent::__construct();

		$this->data['title'] = 'Om oss';
		$this->data['slug'] = 'about';
	}

	public function index()
	{
		$this->render('@pages/about.twig');
	}
	
}