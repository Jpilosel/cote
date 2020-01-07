<?php

namespace FdjBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JoueurTennisScoreCote
 *
 * @ORM\Table(name="joueur_tennis_score_cote")
 * @ORM\Entity(repositoryClass="FdjBundle\Repository\JoueurTennisScoreCoteRepository")
 */
class JoueurTennisScoreCote
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
     * @ORM\Column(name="cote", type="string", length=255)
     */
    private $cote;

    /**
     * @var string
     *
     * @ORM\Column(name="resultat", type="string", length=255)
     */
    private $resultat;

    /**
     * @var string
     *
     * @ORM\Column(name="victoire", type="string", length=255)
     */
    private $victoire;

    /**
     * @var string
     *
     * @ORM\Column(name="coteAdversaire", type="string", length=255)
     */
    private $coteAdversaire;

    /**
     * @var string
     *
     * @ORM\Column(name="nomAdversaire", type="string", length=255)
     */
    private $nomAdversaire;

    /**
     * @var string
     *
     * @ORM\Column(name="competition", type="string", length=255)
     */
    private $competiton;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

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
     * @return JoueurTennisScoreCote
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
     * Set cote
     *
     * @param string $cote
     * @return JoueurTennisScoreCote
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
     * Set resultat
     *
     * @param string $resultat
     * @return JoueurTennisScoreCote
     */
    public function setResultat($resultat)
    {
        $this->resultat = $resultat;

        return $this;
    }

    /**
     * Get resultat
     *
     * @return string 
     */
    public function getResultat()
    {
        return $this->resultat;
    }

    /**
     * Set coteAdversaire
     *
     * @param string $coteAdversaire
     * @return JoueurTennisScoreCote
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
     * @return string
     */
    public function getCompetiton()
    {
        return $this->competiton;
    }

    /**
     * @param string $competiton
     */
    public function setCompetiton($competiton)
    {
        $this->competiton = $competiton;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = $date;
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
    public function getVictoire()
    {
        return $this->victoire;
    }

    /**
     * @param string $victoire
     */
    public function setVictoire($victoire)
    {
        $this->victoire = $victoire;
    }

}
