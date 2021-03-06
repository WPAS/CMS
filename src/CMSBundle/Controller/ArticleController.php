<?php

namespace CMSBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

use CMSBundle\Entity\Article;


class ArticleController extends FOSRestController
{
    /**
     * @Rest\Get("/articles")
     */
    public function getArticlesAction()
    {
        $repository = $this->getDoctrine()->getRepository('CMSBundle:Article');
        $articles = $repository->getSomeFromNewest(20);
        
        if(!$articles) {
            return new View("There are no articles", Response::HTTP_NOT_FOUND);
        }
        
        return $articles;
    }
    
    /**
     * @Rest\Get("/newestArticles")
     */
    public function getNewestArticlesAction()
    {
        $repository = $this->getDoctrine()->getRepository('CMSBundle:Article');
        $articles = $repository->getSomeFromNewest(3);
        
        if(!$articles) {
            return new View("There are no articles", Response::HTTP_NOT_FOUND);
        }
        
        return $articles;
    }


    /**
     * @Rest\Get("/articles/{id}")
     */    
    public function getArticleAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('CMSBundle:Article');
        $article = $repository->find($id);

        if(!$article) {
            return new View("This article do not exist", Response::HTTP_NOT_FOUND);
        }
        
        return $article;
    }
  
    /**
     * @Rest\Post("/articles")
     */
    public function postArticleAction(Request $request)
    {
        $article = new Article();

        $title = $request->get('title');
        $text = $request->get('text');
        $author = $request->get('author');
        $date = $request->get('date');

        if(empty($title) || empty($text) || empty($author) || empty($date) ){
            return new View("Null values are not allowed", Response::HTTP_NOT_ACCEPTABLE);
        }

        $article->setTitle($title);
        $article->setText($text);
        $article->setAuthor($author);
        $article->setDate($date);        

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
        return new View("Article added successfully", Response::HTTP_OK);
 
    }
    
    /**
     * @Rest\Delete("/articles/{id}")
    */
    public function deleteArticleAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $repository = $this->getDoctrine()->getRepository('CMSBundle:Article');
        $article = $repository->find($id);

        if (empty($article)) {
            return new View("The article do not exist", Response::HTTP_NOT_FOUND);
        } else {
            $em->remove($article);
            $em->flush();
        }
        
        return new View("Article deleted successfully", Response::HTTP_OK);
    }
    
    /**
    * @Rest\Put("/articles/{id}")
    */
    public function updateAction($id, Request $request)
    { 
        $em = $this->getDoctrine()->getManager();
        
        $repository = $this->getDoctrine()->getRepository('CMSBundle:Article');
        $article = $repository->find($id);
        
        if(!$article) {
            return new View("This article do not exist", Response::HTTP_NOT_FOUND);
        }

        $title = $request->get('title');
        $text = $request->get('text');
        $author = $request->get('author');

        $article->setTitle($title);
        $article->setText($text);
        $article->setAuthor($author);

        $em->flush();
        return new View("Article Updated Successfully", Response::HTTP_OK);
    }
}
