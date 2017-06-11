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
    
    /**
     * @Rest\Post("/pages")
     */
    public function postPageAction(Request $request)
    {
        $page = new Page();

        $title = $request->get('title');
        $text = $request->get('text');
        $date = $request->get('date');

        if(empty($title) || empty($text) || empty($date) ){
            return new View("Null values are not allowed", Response::HTTP_NOT_ACCEPTABLE);
        }

        $page->setTitle($title);
        $page->setText($text);
        $page->setDate($date);        

        $em = $this->getDoctrine()->getManager();
        $em->persist($page);
        $em->flush();
        return new View("Page added successfully", Response::HTTP_OK);        
    }
    
    /**
    * @Rest\Put("/pages/{id}")
    */
    public function updateAction($id, Request $request)
    { 
        $em = $this->getDoctrine()->getManager();
        
        $repository = $this->getDoctrine()->getRepository('CMSBundle:Page');
        $page = $repository->find($id);
        
        if($page === null) {
            return new View("This page do not exist", Response::HTTP_NOT_FOUND);
        }

        $title = $request->get('title');
        $text = $request->get('text');

        $page->setTitle($title);
        $page->setText($text);

        $em->flush();
        return new View("Page updated successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/pages/{id}")
    */
    public function deleteArticleAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $repository = $this->getDoctrine()->getRepository('CMSBundle:Page');
        $page = $repository->find($id);

        if (empty($page)) {
            return new View("The page do not exist", Response::HTTP_NOT_FOUND);
        } else {
            $em->remove($page);
            $em->flush();
        }
        
        return new View("Page deleted successfully", Response::HTTP_OK);
    }

    
    

}
