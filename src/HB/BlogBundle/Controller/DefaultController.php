<?php

namespace HB\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controleur de l'entité Article
 * 
 * @author humanbooster
 */
class DefaultController extends Controller
{

	/**
	 * Affiche un article sur un Id
	 *
	 * On ajoute une méthode getArticle
	 * @Route("/")
	 */
	public function index()
	{
		return new Response("Bienvenue sur le WebService SfCloud.");
	}
}
