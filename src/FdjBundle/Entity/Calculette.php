<?php

namespace FdjBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Calculette
 *
 * @ORM\Table(name="calculette")
 * @ORM\Entity(repositoryClass="FdjBundle\Repository\CalculetteRepository")
 */
class Calculette
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
     * @var int
     *
     * @ORM\Column(name="serieGain", type="integer")
     */
    private $serieGain;

    /**
     * @var int
     *
     * @ORM\Column(name="perte", type="decimal", scale=2)
     */
    private $perte;

    /**
     * @var int
     *
     * @ORM\Column(name="pertePrecedente", type="decimal", scale=2, nullable=true)
     */
    private $pertePrecedente;

    /**
     * @var int
     *
     * @ORM\Column(name="palier", type="decimal", scale=2, nullable=true)
     */
    private $palier;

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
     * Set serieGain
     *
     * @param integer $serieGain
     * @return Calculette
     */
    public function setSerieGain($serieGain)
    {
        $this->serieGain = $serieGain;

        return $this;
    }

    /**
     * Get serieGain
     *
     * @return integer 
     */
    public function getSerieGain()
    {
        return $this->serieGain;
    }

    /**
     * Set perte
     *
     * @param integer $perte
     * @return Calculette
     */
    public function setPerte($perte)
    {
        $this->perte = $perte;

        return $this;
    }

    /**
     * Get perte
     *
     * @return integer 
     */
    public function getPerte()
    {
        return $this->perte;
    }

    /**
     * @return int
     */
    public function getPertePrecedente()
    {
        return $this->pertePrecedente;
    }

    /**
     * @param int $pertePrecedente
     */
    public function setPertePrecedente($pertePrecedente)
    {
        $this->pertePrecedente = $pertePrecedente;
    }

    /**
     * @return int
     */
    public function getPalier()
    {
        return $this->palier;
    }

    /**
     * @param int $palier
     */
    public function setPalier($palier)
    {
        $this->palier = $palier;
    }


}
