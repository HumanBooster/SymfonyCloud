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
        return array();
    }
    
    /**
	 * Affiche un article sur un Id
	 * 
	 * @Route("/{id}")
	 * @Template()
	 */
	public function readAction()
	{
		return array();
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
	 * Affiche un formulaire pour éditer un article sur un Id
	 *
	 * @Route("/{id}/edit")
	 * @Template()
	 */
	public function editAction()
	{
		return array();
	}
	
	/**
	 * Supprime un article sur un Id
	 *
	 * @Route("/{id}/delete")
	 * @Template()
	 */
	public function deleteAction()
	{
		return array();
	}
}
