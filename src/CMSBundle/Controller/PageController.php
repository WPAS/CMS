<?php

namespace CMSBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

use CMSBundle\Entity\Page;


class PageController extends FOSRestController
{
    /**
     * @Rest\Get("/pages")
     */
    public function getPagesAction()
    {
        $repository = $this->getDoctrine()->getRepository('CMSBundle:Page');
        $pages = $repository->findAll();
        
        if($pages === null) {
            return new View("There are no pages", Response::HTTP_NOT_FOUND);
        }
        
        return $pages;
    }

    /**
     * @Rest\Get("/pages/{id}")
     */    
    public function getPageAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('CMSBundle:Page');
        $page = $repository->find($id);

        if($page === null) {
            return new View("This page do not exist", Response::HTTP_NOT_FOUND);
        }
        
        return $page;
    }  

}
