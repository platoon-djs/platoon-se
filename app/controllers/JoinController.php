<?php


/**
 * JoinController
 */
class JoinController extends BaseController
{

    public function __construct()
    {
        parent::__construct();

        $this->data['title'] = 'Gå med';
        $this->data['slug'] = 'join';
    }

    public function index()
    {
        $this->render('@pages/join.twig');
    }

}
