<?php

namespace FdjBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TennisCoteCumul
 *
 * @ORM\Table(name="tennis_cote_cumul")
 * @ORM\Entity(repositoryClass="FdjBundle\Repository\TennisCoteCumulRepository")
 */
class TennisCoteCumul
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
     * @ORM\Column(name="marketTypeId", type="integer")
     */
    private $marketTypeId;

    /**
     * @var string
     *
     * @ORM\Column(name="cote", type="string", length=255)
     */
    private $cote;

    /**
     * @var string
     *
     * @ORM\Column(name="sport", type="integer", nullable=true)
     */
    private $sport;

    /**
     * @var int
     *
     * @ORM\Column(name="win", type="integer")
     */
    private $win;

    /**
     * @var int
     *
     * @ORM\Column(name="loose", type="integer")
     */
    private $loose;


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
     * Set cote
     *
     * @param string $cote
     * @return TennisCoteCumul
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
     * Set win
     *
     * @param integer $win
     * @return TennisCoteCumul
     */
    public function setWin($win)
    {
        $this->win = $win;

        return $this;
    }

    /**
     * Get win
     *
     * @return integer 
     */
    public function getWin()
    {
        return $this->win;
    }

    /**
     * Set loose
     *
     * @param integer $loose
     * @return TennisCoteCumul
     */
    public function setLoose($loose)
    {
        $this->loose = $loose;

        return $this;
    }

    /**
     * Get loose
     *
     * @return integer 
     */
    public function getLoose()
    {
        return $this->loose;
    }

    /**
     * @return string
     */
    public function getMarketTypeId()
    {
        return $this->marketTypeId;
    }

    /**
     * @param string $marketTypeId
     */
    public function setMarketTypeId($marketTypeId)
    {
        $this->marketTypeId = $marketTypeId;
    }

    /**
     * @return string
     */
    public function getSport()
    {
        return $this->sport;
    }

    /**
     * @param string $sport
     */
    public function setSport($sport)
    {
        $this->sport = $sport;
    }


}
