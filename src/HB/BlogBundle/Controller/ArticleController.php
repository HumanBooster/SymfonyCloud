<?php

namespace HB\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use HB\BlogBundle\Entity\Article;
use HB\BlogBundle\Form\ArticleType;

use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * Controleur de l'entité Article
 * 
 * @author humanbooster
 * 
 * @Route("/article")
 */
class ArticleController extends Controller
{
    /**
     * Liste tous les articles
     * 
     * @Route("/", name="article_list")
     * @Template()
     */
    public function indexAction()
    {
		// on récupère le repository de l'Article
		/*$repository = $this->getDoctrine()->getRepository("HBBlogBundle:Article");
		// on demande au repository tous les articles
		$articles = $repository->findAll();*/

		$client = $this->container->get('besimple.soap.client.blogapi');
		$articles = $client->getArticles();
		
		//print_r($articles);
		// on transmet la liste à la vue
		return array('articles' => $articles->item);
    }

    /**
     * Affiche un formulaire pour ajouter un article
     *
     * @Route("/add", name="article_add")
     * @Template()
     */
    public function addAction()
    {
		return $this->editAction(0);
    }
    
    /**
	 * Affiche un article sur un Id
	 * 
	 * @Route("/{id}", name="article_read")
	 * @Template()
	 */
	public function readAction($id)
	{
		$client = $this->container->get('besimple.soap.client.blogapi');
		$article = $client->getArticle($id);
		
		// on transmet notre article à la vue
		return array('article' => $article);
	}
	
	/**
	 * Affiche un formulaire pour éditer un article sur un Id
	 *
	 * @Route("/{id}/edit", name="article_edit")
	 * @Route("/titre/{titre}/edit")
	 * @Template("HBBlogBundle:Article:add.html.twig")
	 */
	public function editAction($id)
	{	
		$client = $this->container->get('besimple.soap.client.blogapi');
	
		if ($id > 0) {		
			$article = $client->getArticle($id);
		} else {
			$article = new Article();
		}
		
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
				$client->putArticle($article);
				 
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
	 * @Route("/{id}/delete", name="article_delete")
	 */
	public function deleteAction($id)
	{
		// on a récupéré l'article grace à un ParamConverter magique
		// on demande à l'entity manager de supprimer l'article
		$client = $this->container->get('besimple.soap.client.blogapi');
		$client->deleteArticle($id);
	
		// On redirige vers la page de liste des articles
		return $this->redirect(
				$this->generateUrl('article_list')
		);
	}
	
	/**
	 * Affiche l'auteur d'un article
	 * 
	 * @param Article $article
	 * 
	 * @Route("/{id}/auteur", name="article_auteur")
	 */
	public function readAuteurAction(Article $article) {
		if ($article->getAuteur()!=null) {
			return $this->redirect(
				$this->generateUrl('utilisateur_read', array('id' => $article->getAuteur()->getId()))
			);
		} else {
			throw new NotFoundResourceException("Auteur invalide.");
		}
	}
}
