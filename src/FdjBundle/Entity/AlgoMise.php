<?php

namespace FdjBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AlgoMise
 *
 * @ORM\Table(name="algo_mise")
 * @ORM\Entity(repositoryClass="FdjBundle\Repository\AlgoMiseRepository")
 */
class AlgoMise
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
     * @ORM\Column(name="utilisateur", type="string", length=255)
     */
    private $utilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="perte", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $perte;

    /**
     * @var int
     *
     * @ORM\Column(name="palier", type="integer", nullable=true)
     */
    private $palier;

    /**
     * @var int
     *
     * @ORM\Column(name="start", type="integer", nullable=true)
     */
    private $start;


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
     * Set utilisateur
     *
     * @param string $utilisateur
     * @return AlgoMise
     */
    public function setUtilisateur($utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return string 
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set perte
     *
     * @param string $perte
     * @return AlgoMise
     */
    public function setPerte($perte)
    {
        $this->perte = $perte;

        return $this;
    }

    /**
     * Get perte
     *
     * @return string 
     */
    public function getPerte()
    {
        return $this->perte;
    }

    /**
     * Set palier
     *
     * @param integer $palier
     * @return AlgoMise
     */
    public function setPalier($palier)
    {
        $this->palier = $palier;

        return $this;
    }

    /**
     * Get palier
     *
     * @return integer 
     */
    public function getPalier()
    {
        return $this->palier;
    }

    /**
     * Set start
     *
     * @param integer $start
     * @return AlgoMise
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return integer 
     */
    public function getStart()
    {
        return $this->start;
    }
}
