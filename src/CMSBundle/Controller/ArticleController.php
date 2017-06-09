<?php

namespace CMSBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

use CMSBundle\Entity\Article;


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
    
    public function getArticleAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('CMSBundle:Article');
        $articles = $repository->find($id);
        
        $view = $this->view($articles, 200);
        $response = $this->handleView($view);
        $response->headers->set('Access-Control-Allow-Origin', '*');  
        return $response;
    }
  
    public function postArticleAction(Request $request)
    {
        $article = new Article();
        
        $title = $request->request->get('title');
        $text = $request->request->get('text');
        $author = $request->request->get('author');
        $date = $request->request->get('date');        
        
        $article->setTitle($title);
        $article->setText($text);
        $article->setAuthor($author);
        $article->setDate($date);
        
//        $article->setTitle("test");
//        $article->setText("test");
//        $article->setAuthor("test");
//        $article->setDate("test");     
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        $view = $this->view("New article added", 201);
        $response = $this->handleView($view);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
      
    }

    
}
