<?php

namespace FdjBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClassementJoueurs
 *
 * @ORM\Table(name="classement_joueurs")
 * @ORM\Entity(repositoryClass="FdjBundle\Repository\ClassementJoueursRepository")
 */
class ClassementJoueurs
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
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="annee", type="string", length=255)
     */
    private $annee;

    /**
     * @var string
     *
     * @ORM\Column(name="semaine", type="string", length=255)
     */
    private $semaine;

    /**
     * @var string
     *
     * @ORM\Column(name="nomJoueurs", type="string", length=255)
     */
    private $nomJoueurs;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="idJoueur", type="string", length=255)
     */
    private $idJoueur;

    /**
     * @var string
     *
     * @ORM\Column(name="nationalite", type="string", length=255)
     */
    private $nationalite;

    /**
     * @var string
     *
     * @ORM\Column(name="rang", type="string", length=255)
     */
    private $rang;

    /**
     * @var string
     *
     * @ORM\Column(name="points", type="string", length=255)
     */
    private $points;

    /**
     * @var string
     *
     * @ORM\Column(name="rangMouvement", type="string", length=255)
     */
    private $rangMouvement;

    /**
     * @var string
     *
     * @ORM\Column(name="tournoisJoue", type="string", length=255)
     */
    private $tournoisJoue;


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
     * Set type
     *
     * @param string $type
     * @return ClassementJoueurs
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
     * Set annee
     *
     * @param string $annee
     * @return ClassementJoueurs
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return string 
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set semaine
     *
     * @param string $semaine
     * @return ClassementJoueurs
     */
    public function setSemaine($semaine)
    {
        $this->semaine = $semaine;

        return $this;
    }

    /**
     * Get semaine
     *
     * @return string 
     */
    public function getSemaine()
    {
        return $this->semaine;
    }

    /**
     * Set nomJoueurs
     *
     * @param string $nomJoueurs
     * @return ClassementJoueurs
     */
    public function setNomJoueurs($nomJoueurs)
    {
        $this->nomJoueurs = $nomJoueurs;

        return $this;
    }

    /**
     * Get nomJoueurs
     *
     * @return string 
     */
    public function getNomJoueurs()
    {
        return $this->nomJoueurs;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }



    /**
     * Set idJoueur
     *
     * @param string $idJoueur
     * @return ClassementJoueurs
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
     * Set nationalite
     *
     * @param string $nationalite
     * @return ClassementJoueurs
     */
    public function setNationalite($nationalite)
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * Get nationalite
     *
     * @return string 
     */
    public function getNationalite()
    {
        return $this->nationalite;
    }

    /**
     * Set rang
     *
     * @param string $rang
     * @return ClassementJoueurs
     */
    public function setRang($rang)
    {
        $this->rang = $rang;

        return $this;
    }

    /**
     * Get rang
     *
     * @return string 
     */
    public function getRang()
    {
        return $this->rang;
    }

    /**
     * Set points
     *
     * @param string $points
     * @return ClassementJoueurs
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return string 
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set rangMouvement
     *
     * @param string $rangMouvement
     * @return ClassementJoueurs
     */
    public function setRangMouvement($rangMouvement)
    {
        $this->rangMouvement = $rangMouvement;

        return $this;
    }

    /**
     * Get rangMouvement
     *
     * @return string 
     */
    public function getRangMouvement()
    {
        return $this->rangMouvement;
    }

    /**
     * Set tournoisJoue
     *
     * @param string $tournoisJoue
     * @return ClassementJoueurs
     */
    public function setTournoisJoue($tournoisJoue)
    {
        $this->tournoisJoue = $tournoisJoue;

        return $this;
    }

    /**
     * Get tournoisJoue
     *
     * @return string 
     */
    public function getTournoisJoue()
    {
        return $this->tournoisJoue;
    }
}
