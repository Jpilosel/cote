<?php

namespace FdjBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cote
 *
 * @ORM\Table(name="cote")
 * @ORM\Entity(repositoryClass="FdjBundle\Repository\CoteRepository")
 */
class Cote
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
     * @ORM\Column(name="sportId", type="string", length=255)
     */
    private $sportId;

    /**
     * @var string
     *
     * @ORM\Column(name="competition", type="string", length=255)
     */
    private $competition;

    /**
     * @var string
     *
     * @ORM\Column(name="CompetitionId", type="string", length=255)
     */
    private $competitionId;

    /**
     * @var string
     *
     * @ORM\Column(name="marketType", type="string", length=255)
     */
    private $marketType;

    /**
     * @var string
     *
     * @ORM\Column(name="marketTypeGroup", type="string", length=255)
     */
    private $marketTypeGroup;

    /**
     * @var string
     *
     * @ORM\Column(name="resultat", type="string", length=255)
     */
    private $resultat;

    /**
     * @var string
     *
     * @ORM\Column(name="cote", type="string", length=255)
     */
    private $cote;

    /**
     * @var string
     *
     * @ORM\Column(name="$statut", type="string", length=255)
     */
    private $statut;

    /**
     * @var string
     *
     * @ORM\Column(name="recurrence", type="string", length=255)
     */
    private $recurrence;


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
     * Set sportId
     *
     * @param string $sportId
     * @return Cote
     */
    public function setSportId($sportId)
    {
        $this->sportId = $sportId;

        return $this;
    }

    /**
     * Get sportId
     *
     * @return string 
     */
    public function getSportId()
    {
        return $this->sportId;
    }

    /**
     * Set competition
     *
     * @param string $competition
     * @return Cote
     */
    public function setCompetition($competition)
    {
        $this->competition = $competition;

        return $this;
    }

    /**
     * Get competition
     *
     * @return string 
     */
    public function getCompetition()
    {
        return $this->competition;
    }

    /**
     * Set competitionId
     *
     * @param string $competitionId
     * @return Cote
     */
    public function setCompetitionId($competitionId)
    {
        $this->competitionId = $competitionId;

        return $this;
    }

    /**
     * Get competitionId
     *
     * @return string 
     */
    public function getCompetitionId()
    {
        return $this->competitionId;
    }

    /**
     * Set marketType
     *
     * @param string $marketType
     * @return Cote
     */
    public function setMarketType($marketType)
    {
        $this->marketType = $marketType;

        return $this;
    }

    /**
     * Get marketType
     *
     * @return string 
     */
    public function getMarketType()
    {
        return $this->marketType;
    }

    /**
     * Set marketTypeGroup
     *
     * @param string $marketTypeGroup
     * @return Cote
     */
    public function setMarketTypeGroup($marketTypeGroup)
    {
        $this->marketTypeGroup = $marketTypeGroup;

        return $this;
    }

    /**
     * Get marketTypeGroup
     *
     * @return string 
     */
    public function getMarketTypeGroup()
    {
        return $this->marketTypeGroup;
    }

    /**
     * Set resultat
     *
     * @param string $resultat
     * @return Cote
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
     * Set cote
     *
     * @param string $cote
     * @return Cote
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
     * @return string
     */
    public function getRecurrence()
    {
        return $this->recurrence;
    }

    /**
     * @param string $recurrence
     */
    public function setRecurrence($recurrence)
    {
        $this->recurrence = $recurrence;
    }

    /**
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @param string $statut
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
    }



}
