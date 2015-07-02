<?php


/**
 * IndexController
 */
class IndexController extends BaseController
{

	public function index()
	{
		$this->render('@pages/index.twig', [
			'navpadding' => false
		]);
	}
	
}