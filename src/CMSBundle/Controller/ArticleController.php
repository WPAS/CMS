<?php

namespace CMSBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

class ArticleController extends FOSRestController
{
    public function getArticlesAction()
    {
        $repository = $this->getDoctrine()->getRepository('CMSBundle:Article');
        $articles = $repository->findAll();
        
        $view = $this->view($articles, 200);
        $response = $this->handleView($view);
        $response->headers->set('Access-Control-Allow-Origin', '*');  
        return $response;
    }
}
