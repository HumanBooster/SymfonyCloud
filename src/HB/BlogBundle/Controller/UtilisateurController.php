<?php

namespace HB\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use HB\BlogBundle\Entity\Utilisateur;
use HB\BlogBundle\Form\UtilisateurType;

/**
 * Controleur de l'entité Utilisateur
 * 
 * @author humanbooster
 * 
 * @Route("/utilisateur")
 */
class UtilisateurController extends Controller
{
    /**
     * Liste tous les utilisateurs
     * 
     * @Route("/", name="utilisateur_list")
     * @Template()
     */
    public function indexAction()
    {
		// on récupère le repository de l'Utilisateur
		$repository = $this->getDoctrine()->getRepository("HBBlogBundle:Utilisateur");
		// on demande au repository tous les utilisateurs
		$utilisateurs = $repository->findAll();

		
		// on transmet la liste à la vue
		return array('utilisateurs' => $utilisateurs);
    }
    
    /**
     * Affiche un formulaire pour ajouter un utilisateur
     *
     * @Route("/add", name="utilisateur_add")
     * @Template()
     */
    public function addAction()
    {
    	$utilisateur = new Utilisateur;
		return $this->editAction($utilisateur);
    }
    
    /**
	 * Affiche un utilisateur sur un Id
	 * 
	 * @Route("/{id}", name="utilisateur_read")
	 * @Template()
	 */
	public function readAction(Utilisateur $utilisateur)
	{
		// on a récupéré l'utilisateur grace à un ParamConverter magique
		// on transmet notre utilisateur à la vue
		return array('utilisateur' => $utilisateur);
	}
	
	/**
	 * Affiche un formulaire pour éditer un utilisateur sur un Id
	 *
	 * @Route("/{id}/edit", name="utilisateur_edit")
	 * @Route("/titre/{titre}/edit")
	 * @Template("HBBlogBundle:Utilisateur:add.html.twig")
	 */
	public function editAction(Utilisateur $utilisateur)
	{		 
		// on créé un objet formulaire en lui précisant quel Type utiliser
		$form = $this->createForm(new UtilisateurType, $utilisateur);
		 
		// On récupère la requête
		$request = $this->get('request');
		 
		// On vérifie qu'elle est de type POST pour voir si un formulaire a été soumis
		if ($request->getMethod() == 'POST') {
			// On fait le lien Requête <-> Formulaire
			// À partir de maintenant, la variable $utilisateur contient les valeurs entrées dans
			// le formulaire par le visiteur
			$form->bind($request);
			// On vérifie que les valeurs entrées sont correctes
			// (Nous verrons la validation des objets en détail dans le prochain chapitre)
			if ($form->isValid()) {
				// On l'enregistre notre objet $utilisateur dans la base de données
				$em = $this->getDoctrine()->getManager();
				$em->persist($utilisateur);
				$em->flush();
				 
				// On redirige vers la page de visualisation de l'utilisateur nouvellement créé
				return $this->redirect(
						$this->generateUrl('utilisateur_read', array('id' => $utilisateur->getId()))
				);
			}
		}
		
		if ($utilisateur->getId()>0)
			$edition = true;
		else
			$edition = false;
		 
		// passe la vue de formulaire à la vue
		return array( 'formulaire' => $form->createView(), 'edition' => $edition );
	}
	
	/**
	 * Supprime un utilisateur sur un Id
	 *
	 * @Route("/{id}/delete", name="utilisateur_delete")
	 */
	public function deleteAction(Utilisateur $utilisateur)
	{
		// on a récupéré l'utilisateur grace à un ParamConverter magique
		// on demande à l'entity manager de supprimer l'utilisateur
		$em = $this->getDoctrine()->getEntityManager();
		$em->remove($utilisateur);
		$em->flush();
	
		// On redirige vers la page de liste des utilisateurs
		return $this->redirect(
				$this->generateUrl('utilisateur_list')
		);
	}
	
	/**
	 * Liste les articles d'un utilisateur
	 * 
	 * @Route("/{id}/articles", name="utilisateur_articles")
	 * @Template()
	 *
	 */
	public function listArticlesAction(Utilisateur $utilisateur)
	{
		return array('utilisateur' => $utilisateur,
					 'articles' => $utilisateur->getArticles()
		);
	}
}
