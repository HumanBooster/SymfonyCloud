<?php

namespace HB\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
     * @Route("/")
     * @Template()
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
     * @Route("/add")
     * @Template()
     */
    public function addAction()
    {
    	return array();
    }
    
    /**
	 * Affiche un article sur un Id
	 * 
	 * @Route("/{id}", name="article_read")
	 * @Template()
	 */
	public function readAction($id)
	{
		// on récupère le repository de l'Article
		$repository = $this->getDoctrine()->getRepository("HBBlogBundle:Article");
		
		// on demande au repository l'article par l'id
		$article = $repository->find($id);

		
		// on transmet notre article à la vue
		return array('article' => $article);
	}
	
	/**
	 * Affiche un formulaire pour éditer un article sur un Id
	 *
	 * @Route("/{id}/edit")
	 * @Template()
	 */
	public function editAction($id)
	{
		return array();
	}
	
	/**
	 * Supprime un article sur un Id
	 *
	 * @Route("/{id}/delete")
	 * @Template()
	 */
	public function deleteAction($id)
	{
		return array();
	}
}
