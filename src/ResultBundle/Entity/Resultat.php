<?php

namespace ResultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Resultat
 *
 * @ORM\Table(name="resultat")
 * @ORM\Entity(repositoryClass="ResultBundle\Repository\ResultatRepository")
 */
class Resultat
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
     * @ORM\Column(name="nbResult", type="integer")
     */
    private $nbResult;

    /**
     * @var string
     *
     * @ORM\Column(name="sport", type="string", length=255)
     */
    private $sport;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=1)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="competition", type="string", length=255)
     */
    private $competition;

    /**
     * @var string
     *
     * @ORM\Column(name="rencontre", type="string", length=255)
     */
    private $rencontre;

    /**
     * @var string
     *
     * @ORM\Column(name="equipe1", type="string", length=255)
     */
    private $equipe1;

    /**
     * @var string
     *
     * @ORM\Column(name="cote1", type="string", length=255)
     */
    private $cote1;

    /**
     * @var string
     *
     * @ORM\Column(name="coteNull", type="string", length=255, nullable=true)
     */
    private $coteNull;

    /**
     * @var string
     *
     * @ORM\Column(name="equipe2", type="string", length=255)
     */
    private $equipe2;

    /**
     * @var string
     *
     * @ORM\Column(name="cote2", type="string", length=255)
     */
    private $cote2;

    /**
     * @var string
     *
     * @ORM\Column(name="resultat", type="string", length=255, nullable=true)
     */
    private $resultat;

    /**
     * @var string
     *
     * @ORM\Column(name="coteGagnante", type="string", length=255)
     */
    private $coteGagnante;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

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
     * Set nbResult
     *
     * @param integer $nbResult
     * @return Resultat
     */
    public function setNbResult($nbResult)
    {
        $this->nbResult = $nbResult;

        return $this;
    }

    /**
     * Get nbResult
     *
     * @return integer 
     */
    public function getNbResult()
    {
        return $this->nbResult;
    }

    /**
     * Set sport
     *
     * @param string $sport
     * @return Resultat
     */
    public function setSport($sport)
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * Get sport
     *
     * @return string 
     */
    public function getSport()
    {
        return $this->sport;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     * @return Resultat
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string 
     */
    public function getSexe()
    {
        return $this->sexe;
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
     * Set rencontre
     *
     * @param string $rencontre
     * @return Resultat
     */
    public function setRencontre($rencontre)
    {
        $this->rencontre = $rencontre;

        return $this;
    }

    /**
     * Get rencontre
     *
     * @return string 
     */
    public function getRencontre()
    {
        return $this->rencontre;
    }

    /**
     * Set equipe1
     *
     * @param string $equipe1
     * @return Resultat
     */
    public function setEquipe1($equipe1)
    {
        $this->equipe1 = $equipe1;

        return $this;
    }

    /**
     * Get equipe1
     *
     * @return string 
     */
    public function getEquipe1()
    {
        return $this->equipe1;
    }

    /**
     * Set cote1
     *
     * @param string $cote1
     * @return Resultat
     */
    public function setCote1($cote1)
    {
        $this->cote1 = $cote1;

        return $this;
    }

    /**
     * Get cote1
     *
     * @return string 
     */
    public function getCote1()
    {
        return $this->cote1;
    }

    /**
     * @return string
     */
    public function getCoteNull()
    {
        return $this->coteNull;
    }

    /**
     * @param string $coteNull
     */
    public function setCoteNull($coteNull)
    {
        $this->coteNull = $coteNull;
    }

    /**
     * Set equipe2
     *
     * @param string $equipe2
     * @return Resultat
     */
    public function setEquipe2($equipe2)
    {
        $this->equipe2 = $equipe2;

        return $this;
    }

    /**
     * Get equipe2
     *
     * @return string 
     */
    public function getEquipe2()
    {
        return $this->equipe2;
    }

    /**
     * Set cote2
     *
     * @param string $cote2
     * @return Resultat
     */
    public function setCote2($cote2)
    {
        $this->cote2 = $cote2;

        return $this;
    }

    /**
     * Get cote2
     *
     * @return string 
     */
    public function getCote2()
    {
        return $this->cote2;
    }

    /**
     * Set resultat
     *
     * @param string $resultat
     * @return Resultat
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
     * Set coteGagnante
     *
     * @param string $coteGagnante
     * @return Resultat
     */
    public function setCoteGagnante($coteGagnante)
    {
        $this->coteGagnante = $coteGagnante;

        return $this;
    }

    /**
     * Get coteGagnante
     *
     * @return string 
     */
    public function getCoteGagnante()
    {
        return $this->coteGagnante;
    }
}
