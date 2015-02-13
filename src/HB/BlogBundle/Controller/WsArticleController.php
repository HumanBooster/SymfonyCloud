<?php

namespace HB\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use HB\BlogBundle\Entity\Article;
use HB\BlogBundle\Form\ArticleType;

use BeSimple\SoapBundle\ServiceDefinition\Annotation as Soap;

use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * Controleur de l'entité Article
 * 
 * @author humanbooster
 */
class WsArticleController extends Controller
{

	/**
	 * Affiche un article sur un Id
	 *
	 * @Soap\Method("getArticle")
	 * @Soap\Param("id", phpType = "int")
	 * @Soap\Result(phpType = "HB\BlogBundle\Entity\Article")
	 */
	public function getArticleAction(Article $article)
	{
		// on a récupéré l'article grace à un ParamConverter magique
		// on transmet notre article à la vue
		return $article;
	}
	
    /**
     * Liste tous les articles
     * 
     * @Soap\Method("getArticles")
     * @Soap\Result(phpType = "HB\BlogBundle\Entity\Article[]")
     */
    public function getArticlesAction()
    {
		// on récupère le repository de l'Article
		$repository = $this->getDoctrine()->getRepository("HBBlogBundle:Article");
		// on demande au repository tous les articles
		$articles = $repository->findAll();

		
		// on transmet la liste à la vue
		return $articles;
    }
    
    /**
     * Affiche un formulaire pour ajouter un article
     * 
	 * @Soap\Method("putArticle")
	 * @Soap\Param("article", phpType = "HB\BlogBundle\Entity\Article")
	 * @Soap\Result(phpType = "HB\BlogBundle\Entity\Article")
     */
    public function putArticleAction(Article $article)
    {
    	/* on regarde si on a un article existant add/edit */
    	$em = $this->getDoctrine()->getManager();
    	
    	if ($article->getId()>0) {
    		$oldArticle = $em->find("HBBlogBundle:Article", $article->getId());
    		$article->setDateCreation($oldArticle->getDateCreation());
    		$em->merge($article);
    	} else {
			if ($article->getDateCreation()==null)
				$article->setDateCreation(new \DateTime());
			
			$em->persist($article);
    	}

		$em->flush();
		 
		// On redirige vers la page de visualisation de l'article nouvellement créé
		return $article;
	}
	
	/**
	 * Supprime un article sur un Id
	 *
	 * @Soap\Method("deleteArticle")
	 * @Soap\Param("id", phpType = "int")
	 * @Soap\Result(phpType = "boolean")
	 */
	public function deleteArticleAction(Article $article)
	{
		// on a récupéré l'article grace à un ParamConverter magique
		// on demande à l'entity manager de supprimer l'article
		$em = $this->getDoctrine()->getEntityManager();
		$em->remove($article);
		$em->flush();
	
		// On redirige vers la page de liste des articles
		return true;
	}

}
