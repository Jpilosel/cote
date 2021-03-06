<?php

namespace FdjBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SportCote
 *
 * @ORM\Table(name="sport_cote")
 * @ORM\Entity(repositoryClass="FdjBundle\Repository\SportCoteRepository")
 */
class SportCote
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
     * @ORM\Column(name="hasCombiBonus", type="string", length=255)
     */
    private $hasCombiBonus;

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
     * @ORM\Column(name="un", type="string", length=255, nullable=true)
     */
    private $un;

    /**
     * @var string
     *
     * @ORM\Column(name="nul", type="string", length=255, nullable=true)
     */
    private $nul;

    /**
     * @var string
     *
     * @ORM\Column(name="deux", type="string", length=255, nullable=true)
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
     * Set eventId
     *
     * @param string $eventId
     * @return SportCote
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
     * @return SportCote
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
     * Set hasCombiBonus
     *
     * @param string $hasCombiBonus
     * @return SportCote
     */
    public function setHasCombiBonus($hasCombiBonus)
    {
        $this->hasCombiBonus = $hasCombiBonus;

        return $this;
    }

    /**
     * Get hasCombiBonus
     *
     * @return string 
     */
    public function getHasCombiBonus()
    {
        return $this->hasCombiBonus;
    }

    /**
     * Set sportId
     *
     * @param string $sportId
     * @return SportCote
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
     * @return SportCote
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
     * @return SportCote
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
     * @return SportCote
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
     * @return SportCote
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
     * @return string
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param string $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * @param string $eventType
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;
    }

    /**
     * @return string
     */
    public function getCompetition()
    {
        return $this->competition;
    }

    /**
     * @param string $competition
     */
    public function setCompetition($competition)
    {
        $this->competition = $competition;
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
     * @return string
     */
    public function getUn()
    {
        return $this->un;
    }

    /**
     * @param string $un
     */
    public function setUn($un)
    {
        $this->un = $un;
    }

    /**
     * @return string
     */
    public function getNul()
    {
        return $this->nul;
    }

    /**
     * @param string $nul
     */
    public function setNul($nul)
    {
        $this->nul = $nul;
    }

    /**
     * @return string
     */
    public function getDeux()
    {
        return $this->deux;
    }

    /**
     * @param string $deux
     */
    public function setDeux($deux)
    {
        $this->deux = $deux;
    }


}
