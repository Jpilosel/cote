<?php

namespace FdjBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TennisScore
 *
 * @ORM\Table(name="tennis_score")
 * @ORM\Entity(repositoryClass="FdjBundle\Repository\TennisScoreRepository")
 */
class TennisScore
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
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="eventId", type="string", length=255)
     */
    private $eventId;

    /**
     * @var string
     *
     * @ORM\Column(name="resultat", type="string", length=255)
     */
    private $resultat;

    /**
     * @var int
     *
     * @ORM\Column(name="equipe1", type="integer")
     */
    private $equipe1;

    /**
     * @var int
     *
     * @ORM\Column(name="equipe2", type="integer")
     */
    private $equipe2;

    /**
     * @var string
     *
     * @ORM\Column(name="dateDeSaisie", type="string", length=255)
     */
    private $dateDeSaisie;

    /**
     * @var string
     *
     * @ORM\Column(name="competition", type="string", length=255)
     */
    private $competition;

    /**
     * @var string
     *
     * @ORM\Column(name="competitionId", type="string", length=255)
     */
    private $competitionId;

    /**
     * @var int
     *
     * @ORM\Column(name="nbSetGagnant", type="integer")
     */
    private $nbSetGagnant;

    /**
     * @var int
     *
     * @ORM\Column(name="nbSetPartie", type="integer")
     */
    private $nbSetPartie;

    /**
     * @var int
     *
     * @ORM\Column(name="fani", type="integer")
     */
    private $fani;

    /**
     * @var string
     *
     * @ORM\Column(name="un", type="string", nullable=true)
     */
    private $un;

    /**
     * @var string
     *
     * @ORM\Column(name="deux", type="string", nullable=true)
     */
    private $deux;


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
     * Set label
     *
     * @param string $label
     * @return TennisScore
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string 
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set eventId
     *
     * @param string $eventId
     * @return TennisScore
     */
    public function setEventId($eventId)
    {
        $this->eventId = $eventId;

        return $this;
    }

    /**
     * Get eventId
     *
     * @return string 
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * Set resultat
     *
     * @param string $resultat
     * @return TennisScore
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
     * Set equipe1
     *
     * @param integer $equipe1
     * @return TennisScore
     */
    public function setEquipe1($equipe1)
    {
        $this->equipe1 = $equipe1;

        return $this;
    }

    /**
     * Get equipe1
     *
     * @return integer 
     */
    public function getEquipe1()
    {
        return $this->equipe1;
    }

    /**
     * Set equipe2
     *
     * @param integer $equipe2
     * @return TennisScore
     */
    public function setEquipe2($equipe2)
    {
        $this->equipe2 = $equipe2;

        return $this;
    }

    /**
     * Get equipe2
     *
     * @return integer 
     */
    public function getEquipe2()
    {
        return $this->equipe2;
    }

    /**
     * Set dateDeSaisie
     *
     * @param string $dateDeSaisie
     * @return TennisScore
     */
    public function setDateDeSaisie($dateDeSaisie)
    {
        $this->dateDeSaisie = $dateDeSaisie;

        return $this;
    }

    /**
     * Get dateDeSaisie
     *
     * @return string 
     */
    public function getDateDeSaisie()
    {
        return $this->dateDeSaisie;
    }

    /**
     * Set competition
     *
     * @param string $competition
     * @return TennisScore
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
     * @return string
     */
    public function getCompetitionId()
    {
        return $this->competitionId;
    }

    /**
     * @param string $competitionId
     */
    public function setCompetitionId($competitionId)
    {
        $this->competitionId = $competitionId;
    }

    /**
     * @return int
     */
    public function getNbSetGagnant()
    {
        return $this->nbSetGagnant;
    }

    /**
     * @param int $nbSetGagnant
     */
    public function setNbSetGagnant($nbSetGagnant)
    {
        $this->nbSetGagnant = $nbSetGagnant;
    }

    /**
     * @return int
     */
    public function getNbSetPartie()
    {
        return $this->nbSetPartie;
    }

    /**
     * @param int $nbSetPartie
     */
    public function setNbSetPartie($nbSetPartie)
    {
        $this->nbSetPartie = $nbSetPartie;
    }

    /**
     * @return int
     */
    public function getFani()
    {
        return $this->fani;
    }

    /**
     * @param int $fani
     */
    public function setFani($fani)
    {
        $this->fani = $fani;
    }

    /**
     * @return int
     */
    public function getUn()
    {
        return $this->un;
    }

    /**
     * @param int $un
     */
    public function setUn($un)
    {
        $this->un = $un;
    }

    /**
     * @return int
     */
    public function getDeux()
    {
        return $this->deux;
    }

    /**
     * @param int $deux
     */
    public function setDeux($deux)
    {
        $this->deux = $deux;
    }




}
