<?php

namespace FdjBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoteList
 *
 * @ORM\Table(name="cote_list")
 * @ORM\Entity(repositoryClass="FdjBundle\Repository\CoteListRepository")
 */
class CoteList
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
     * @ORM\Column(name="marketId", type="string", length=255)
     */
    private $marketId;

    /**
     * @var string
     *
     * @ORM\Column(name="sportId", type="string", length=255)
     */
    private $sportId;

    /**
     * @var string
     *
     * @ORM\Column(name="indexP", type="string", length=255)
     */
    private $indexP;

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
     * @ORM\Column(name="end", type="string", length=255)
     */
    private $end;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="eventType", type="string", length=255)
     */
    private $eventType;

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
     * @ORM\Column(name="statut", type="string", length=255)
     */
    private $statut;


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
     * @return CoteList
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
     * Set marketId
     *
     * @param string $marketId
     * @return CoteList
     */
    public function setMarketId($marketId)
    {
        $this->marketId = $marketId;

        return $this;
    }

    /**
     * Get marketId
     *
     * @return string 
     */
    public function getMarketId()
    {
        return $this->marketId;
    }

    /**
     * Set sportId
     *
     * @param string $sportId
     * @return CoteList
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
     * Set indexP
     *
     * @param string $indexP
     * @return CoteList
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
     * Set marketType
     *
     * @param string $marketType
     * @return CoteList
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
     * @return CoteList
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
     * @return CoteList
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
     * Set end
     *
     * @param string $end
     * @return CoteList
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return string 
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set label
     *
     * @param string $label
     * @return CoteList
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
     * Set eventType
     *
     * @param string $eventType
     * @return CoteList
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;

        return $this;
    }

    /**
     * Get eventType
     *
     * @return string 
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * Set competition
     *
     * @param string $competition
     * @return CoteList
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
     * @return CoteList
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
     * Set cote
     *
     * @param string $cote
     * @return CoteList
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
     * @return CoteList
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
     * Set statut
     *
     * @param string $statut
     * @return CoteList
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string 
     */
    public function getStatut()
    {
        return $this->statut;
    }
}
