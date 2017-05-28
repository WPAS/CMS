<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;

class DefaultController extends FOSRestController
{
    
    public function indexAction(Request $request)
    {
        $view = $this->view([1,2,3,4], 200);  
	return $this->handleView($view);
    }
}
