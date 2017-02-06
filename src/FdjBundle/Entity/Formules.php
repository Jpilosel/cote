<?php

namespace FdjBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Formules
 *
 * @ORM\Table(name="formules")
 * @ORM\Entity(repositoryClass="FdjBundle\Repository\FormulesRepository")
 */
class Formules
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
     * @ORM\Column(name="eventId", type="string", length=255)
     */
    private $eventId;

    /**
     * @var string
     *
     * @ORM\Column(name="indexP", type="string", length=255)
     */
    private $indexP;

    /**
     * @var string
     *
     * @ORM\Column(name="sportId", type="string", length=255)
     */
    private $sportId;

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
     * @ORM\Column(name="marketTypeId", type="string", length=255)
     */
    private $marketTypeId;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;

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
     * @var string
     *
     * @ORM\Column(name="result", type="string", length=255)
     */
    private $result;

    /**
     * @var string
     *
     * @ORM\Column(name="ok", type="string", length=255, nullable=true)
     */
    private $ok;

    /**
     * @var string
     *
     * @ORM\Column(name="dateSasie", type="string", length=255, nullable=true)
     */
    private $dateSasie;



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
     * Set eventId
     *
     * @param string $eventId
     * @return Formules
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
     * Set indexP
     *
     * @param string $indexP
     * @return Formules
     */
    public function setIndexP($indexP)
    {
        $this->indexP = $indexP;

        return $this;
    }

    /**
     * Get indexP
     *
     * @return string 
     */
    public function getIndexP()
    {
        return $this->indexP;
    }

    /**
     * Set sportId
     *
     * @param string $sportId
     * @return Formules
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
     * Set marketType
     *
     * @param string $marketType
     * @return Formules
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
     * @return Formules
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
     * Set marketTypeId
     *
     * @param string $marketTypeId
     * @return Formules
     */
    public function setMarketTypeId($marketTypeId)
    {
        $this->marketTypeId = $marketTypeId;

        return $this;
    }

    /**
     * Get marketTypeId
     *
     * @return string 
     */
    public function getMarketTypeId()
    {
        return $this->marketTypeId;
    }

    /**
     * Set label
     *
     * @param string $label
     * @return Formules
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
     * Set competition
     *
     * @param string $competition
     * @return Formules
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
     * @return Formules
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
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param string $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return string
     */
    public function getOk()
    {
        return $this->ok;
    }

    /**
     * @param string $ok
     */
    public function setOk($ok)
    {
        $this->ok = $ok;
    }

    /**
     * @return string
     */
    public function getDateSasie()
    {
        return $this->dateSasie;
    }

    /**
     * @param string $dateSasie
     */
    public function setDateSasie($dateSasie)
    {
        $this->dateSasie = $dateSasie;
    }





}
