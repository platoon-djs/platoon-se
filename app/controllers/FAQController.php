<?php


/**
 * FAQController
 */
class FAQController extends BaseController
{

    public function __construct()
    {
        parent::__construct();

        $this->data['title'] = 'FAQ';
        $this->data['slug'] = 'faq';
    }

    public function index()
    {
        $this->render('@pages/faq.twig');
    }

}
