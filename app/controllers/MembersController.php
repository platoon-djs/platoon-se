<?php


/**
 * MembersController
 */
class MembersController extends BaseController
{

	public function __construct()
	{
		parent::__construct();

		$this->data['title'] = 'Medlemmar';
		$this->data['slug'] = 'members';
	}

	public function index()
	{
		$this->render('@pages/members.twig');
	}
	
}
