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
	 * On ajoute une méthode getArticle
	 * @Soap\Method("getArticle")
	 * 
	 * Qui prend en paramètre d'entrée un id entier
	 * @Soap\Param("id", phpType = "int")
	 * 
	 * Et qui renvoie un objet de la classe Article
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
     * 
     * On retourne un tableau d'articles
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
	 * @Soap\Result(phpType = "boolean")
     */
    public function putArticleAction(Article $article)
    {
    	/* on regarde si on a un article existant add/edit */
    	$em = $this->getDoctrine()->getManager();
    	
    	/* problème de persistance automatique, utilisation de merge... */
    	if ($article->getId()>0) {
    		$oldArticle = $em->find("HBBlogBundle:Article", $article->getId());
    		$article->setDateCreation($oldArticle->getDateCreation());
    	} else {
			if ($article->getDateCreation()==null)
				$article->setDateCreation(new \DateTime());
			
    	}
    	// on utilise merge et non persist puisque notre objet Article ne vient
    	// pas de l'entitymanager mais est instancié à partir de SoapBundle
    	$em->merge($article);
		$em->flush();
		 
		// on renvoie le résultat, plus de test à faire normalement
		return true;
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
		$em = $this->getDoctrine()->getManager();
		$em->remove($article);
		$em->flush();
	
		// On redirige vers la page de liste des articles
		return true;
	}

}
