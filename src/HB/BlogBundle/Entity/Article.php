<?php

namespace HB\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BeSimple\SoapBundle\ServiceDefinition\Annotation as Soap;

/**
 * Article
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @Soap\Alias("Article")
 */
class Article
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Soap\ComplexType("int", nillable=true)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     * @Soap\ComplexType("string")
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text", nullable=true)
     * @Soap\ComplexType("string")
     */
    private $contenu;
    
    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="date_creation", type="datetime")
     * @Soap\ComplexType("dateTime", nillable=true)
     */
    private $dateCreation;
    
    /**
     * @var Utilisateur
     * 
     * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="articles")
     * @ORM\JoinColumn(onDelete = "SET NULL")
     */
    private $auteur;

    
    /**
     * Constructeur de Article
     */
    public function __construct() {
    	$this->dateCreation = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Article
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Article
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Article
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime 
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set auteur
     *
     * @param \HB\BlogBundle\Entity\Utilisateur $auteur
     * @return Article
     */
    public function setAuteur(\HB\BlogBundle\Entity\Utilisateur $auteur = null)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return \HB\BlogBundle\Entity\Utilisateur 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }
}
