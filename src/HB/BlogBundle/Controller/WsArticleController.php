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
     * Liste tous les articles
     * 
     * Soap\Method("getArticles")
     * Soap\Result(phpType = "HB\BlogBundle\Entity\Article[]")
     */
    public function indexAction()
    {
		// on récupère le repository de l'Article
		$repository = $this->getDoctrine()->getRepository("HBBlogBundle:Article");
		// on demande au repository tous les articles
		$articles = $repository->findAll();

		
		// on transmet la liste à la vue
		return array('articles' => $articles);
    }
    
    /**
     * Affiche un formulaire pour ajouter un article
     *
     */
    /*public function addAction()
    {
    	$article = new Article;
		return $this->editAction($article);
    }*/
    
    /**
	 * Affiche un article sur un Id
	 * 
     * @Soap\Method("getArticle")
     * @Soap\Param("id", phpType = "int")
     * @Soap\Result(phpType = "HB\BlogBundle\Entity\Article")
	 */
	public function readAction(Article $article)
	{
		// on a récupéré l'article grace à un ParamConverter magique
		// on transmet notre article à la vue
		return $article;
	}
	
	/**
	 * Affiche un formulaire pour éditer un article sur un Id
	 *
	 */
	public function editAction(Article $article)
	{		 
		// on créé un objet formulaire en lui précisant quel Type utiliser
		$form = $this->createForm(new ArticleType, $article);
		 
		// On récupère la requête
		$request = $this->get('request');
		 
		// On vérifie qu'elle est de type POST pour voir si un formulaire a été soumis
		if ($request->getMethod() == 'POST') {
			// On fait le lien Requête <-> Formulaire
			// À partir de maintenant, la variable $article contient les valeurs entrées dans
			// le formulaire par le visiteur
			$form->bind($request);
			// On vérifie que les valeurs entrées sont correctes
			// (Nous verrons la validation des objets en détail dans le prochain chapitre)
			if ($form->isValid()) {
				// On l'enregistre notre objet $article dans la base de données
				$em = $this->getDoctrine()->getManager();
				$em->persist($article);
				$em->flush();
				 
				// On redirige vers la page de visualisation de l'article nouvellement créé
				return $this->redirect(
						$this->generateUrl('article_read', array('id' => $article->getId()))
				);
			}
		}
		
		if ($article->getId()>0)
			$edition = true;
		else
			$edition = false;
		 
		// passe la vue de formulaire à la vue
		return array( 'formulaire' => $form->createView(), 'edition' => $edition );
	}
	
	/**
	 * Supprime un article sur un Id
	 *
	 */
	public function deleteAction(Article $article)
	{
		// on a récupéré l'article grace à un ParamConverter magique
		// on demande à l'entity manager de supprimer l'article
		$em = $this->getDoctrine()->getEntityManager();
		$em->remove($article);
		$em->flush();
	
		// On redirige vers la page de liste des articles
		return $this->redirect(
				$this->generateUrl('article_list')
		);
	}

}
