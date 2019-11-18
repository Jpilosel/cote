<?php

namespace FdjBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JoueursTennis
 *
 * @ORM\Table(name="joueurs_tennis")
 * @ORM\Entity(repositoryClass="FdjBundle\Repository\JoueursTennisRepository")
 */
class JoueursTennis
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="idJoueur", type="string", length=255, nullable=true)
     */
    private $idJoueur;

    /**
     * @var string
     *
     * @ORM\Column(name="fullIdJoueurs", type="string", length=255, nullable=true)
     */
    private $fullIdJoueurs;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=255, nullable=true)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="classementAtpWta", type="string", length=255, nullable=true)
     */
    private $classementAtpWta;

    /**
     * @var string
     *
     * @ORM\Column(name="idEvent", type="string", length=255)
     */
    private $idEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="cote", type="string", length=255)
     */
    private $cote;

    /**
     * @var string
     *
     * @ORM\Column(name="coteAdversaire", type="string", length=255)
     */
    private $coteAdversaire;

    /**
     * @var string
     *
     * @ORM\Column(name="nbSet", type="string", length=255, nullable=true)
     */
    private $nbSet;

    /**
     * @var string
     *
     * @ORM\Column(name="idCompetiton", type="string", length=255, nullable=true)
     */
    private $idCompetiton;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="nomAdversaire", type="string", length=255, nullable=true)
     */
    private $nomAdversaire;

    /**
     * @var string
     *
     * @ORM\Column(name="classementAtpAdversaire", type="string", length=255, nullable=true)
     */
    private $classementAtpAdversaire;

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
     * Set nom
     *
     * @param string $nom
     * @return JoueursTennis
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return JoueursTennis
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set idJoueur
     *
     * @param string $idJoueur
     * @return JoueursTennis
     */
    public function setIdJoueur($idJoueur)
    {
        $this->idJoueur = $idJoueur;

        return $this;
    }

    /**
     * Get idJoueur
     *
     * @return string 
     */
    public function getIdJoueur()
    {
        return $this->idJoueur;
    }

    /**
     * Set fullIdJoueurs
     *
     * @param string $fullIdJoueurs
     * @return JoueursTennis
     */
    public function setFullIdJoueurs($fullIdJoueurs)
    {
        $this->fullIdJoueurs = $fullIdJoueurs;

        return $this;
    }

    /**
     * Get fullIdJoueurs
     *
     * @return string 
     */
    public function getFullIdJoueurs()
    {
        return $this->fullIdJoueurs;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     * @return JoueursTennis
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string 
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set classementAtpWta
     *
     * @param string $classementAtpWta
     * @return JoueursTennis
     */
    public function setClassementAtpWta($classementAtpWta)
    {
        $this->classementAtpWta = $classementAtpWta;

        return $this;
    }

    /**
     * Get classementAtpWta
     *
     * @return string 
     */
    public function getClassementAtpWta()
    {
        return $this->classementAtpWta;
    }

    /**
     * Set idEvent
     *
     * @param string $idEvent
     * @return JoueursTennis
     */
    public function setIdEvent($idEvent)
    {
        $this->idEvent = $idEvent;

        return $this;
    }

    /**
     * Get idEvent
     *
     * @return string 
     */
    public function getIdEvent()
    {
        return $this->idEvent;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return JoueursTennis
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set cote
     *
     * @param string $cote
     * @return JoueursTennis
     */
    public function setCote($cote)
    {
        $this->cote = $cote;

        return $this;
    }

    /**
     * Get cote
     *
     * @return string 
     */
    public function getCote()
    {
        return $this->cote;
    }

    /**
     * Set coteAdversaire
     *
     * @param string $coteAdversaire
     * @return JoueursTennis
     */
    public function setCoteAdversaire($coteAdversaire)
    {
        $this->coteAdversaire = $coteAdversaire;

        return $this;
    }

    /**
     * Get coteAdversaire
     *
     * @return string 
     */
    public function getCoteAdversaire()
    {
        return $this->coteAdversaire;
    }

    /**
     * Set nbSet
     *
     * @param string $nbSet
     * @return JoueursTennis
     */
    public function setNbSet($nbSet)
    {
        $this->nbSet = $nbSet;

        return $this;
    }

    /**
     * Get nbSet
     *
     * @return string 
     */
    public function getNbSet()
    {
        return $this->nbSet;
    }

    /**
     * Set idCompetiton
     *
     * @param string $idCompetiton
     * @return JoueursTennis
     */
    public function setIdCompetiton($idCompetiton)
    {
        $this->idCompetiton = $idCompetiton;

        return $this;
    }

    /**
     * Get idCompetiton
     *
     * @return string 
     */
    public function getIdCompetiton()
    {
        return $this->idCompetiton;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return JoueursTennis
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getNomAdversaire()
    {
        return $this->nomAdversaire;
    }

    /**
     * @param string $nomAdversaire
     */
    public function setNomAdversaire($nomAdversaire)
    {
        $this->nomAdversaire = $nomAdversaire;
    }

    /**
     * @return string
     */
    public function getClassementAtpAdversaire()
    {
        return $this->classementAtpAdversaire;
    }

    /**
     * @param string $classementAtpAdversaire
     */
    public function setClassementAtpAdversaire($classementAtpAdversaire)
    {
        $this->classementAtpAdversaire = $classementAtpAdversaire;
    }


}
