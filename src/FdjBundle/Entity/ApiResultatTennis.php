<?php

namespace FdjBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ApiResultatTennis
 *
 * @ORM\Table(name="api_resultat_tennis")
 * @ORM\Entity(repositoryClass="FdjBundle\Repository\ApiResultatTennisRepository")
 */
class ApiResultatTennis
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
     * @ORM\Column(name="idMatch", type="string", length=255)
     */
    private $idMatch;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="nomTournois", type="string", length=255)
     */
    private $nomTournois;

    /**
     * @var string
     *
     * @ORM\Column(name="manche", type="string", length=255, nullable=true)
     */
    private $manche;

    /**
     * @var string
     *
     * @ORM\Column(name="idTournois", type="string", length=255)
     */
    private $idTournois;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=255)
     */
    private $genre;

    /**
     * @var string
     *
     * @ORM\Column(name="joueur1Id", type="string", length=255)
     */
    private $joueur1Id;

    /**
     * @var string
     *
     * @ORM\Column(name="joueur1Nom", type="string", length=255)
     */
    private $joueur1Nom;

    /**
     * @var string
     *
     * @ORM\Column(name="joueur1Nationalite", type="string", length=255, nullable=true)
     */
    private $joueur1Nationalite;

    /**
     * @var string
     *
     * @ORM\Column(name="joueur1BracketNumber", type="string", length=255)
     */
    private $joueur1BracketNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="Joueur1Qualifier", type="string", length=255)
     */
    private $joueur1Qualifier;

    /**
     * @var string
     *
     * @ORM\Column(name="joueur2Id", type="string", length=255)
     */
    private $joueur2Id;

    /**
     * @var string
     *
     * @ORM\Column(name="joueur2Nom", type="string", length=255)
     */
    private $joueur2Nom;

    /**
     * @var string
     *
     * @ORM\Column(name="joueur2Nationalite", type="string", length=255, nullable=true)
     */
    private $joueur2Nationalite;

    /**
     * @var string
     *
     * @ORM\Column(name="joueur2BracketNumber", type="string", length=255)
     */
    private $joueur2BracketNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="joueur2Qualifier", type="string", length=255)
     */
    private $joueur2Qualifier;

    /**
     * @var string
     *
     * @ORM\Column(name="idGagnant", type="string", length=255)
     */
    private $idGagnant;

    /**
     * @var string
     *
     * @ORM\Column(name="scoreS1J1", type="string", length=255)
     */
    private $scoreS1J1;

    /**
     * @var string
     *
     * @ORM\Column(name="scoreS1J2", type="string", length=255)
     */
    private $scoreS1J2;

    /**
     * @var string
     *
     * @ORM\Column(name="scoreS2J1", type="string", length=255)
     */
    private $scoreS2J1;

    /**
     * @var string
     *
     * @ORM\Column(name="scoreS2J2", type="string", length=255)
     */
    private $scoreS2J2;

    /**
     * @var string
     *
     * @ORM\Column(name="scoreS3J1", type="string", length=255, nullable=true)
     */
    private $scoreS3J1;

    /**
     * @var string
     *
     * @ORM\Column(name="scoreS3J2", type="string", length=255, nullable=true)
     */
    private $scoreS3J2;

    /**
     * @var string
     *
     * @ORM\Column(name="scoreS4J1", type="string", length=255, nullable=true)
     */
    private $scoreS4J1;

    /**
     * @var string
     *
     * @ORM\Column(name="scoreS4J2", type="string", length=255, nullable=true)
     */
    private $scoreS4J2;

    /**
     * @var string
     *
     * @ORM\Column(name="scoreS5J1", type="string", length=255, nullable=true)
     */
    private $scoreS5J1;

    /**
     * @var string
     *
     * @ORM\Column(name="scoreS5J2", type="string", length=255, nullable=true)
     */
    private $scoreS5J2;

    /**
     * @var string
     *
     * @ORM\Column(name="resultatMatchJ1", type="string", length=255)
     */
    private $resultatMatchJ1;

    /**
     * @var string
     *
     * @ORM\Column(name="resultatMatchJ2", type="string", length=255)
     */
    private $resultatMatchJ2;


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
     * Set idMatch
     *
     * @param string $idMatch
     * @return ApiResultatTennis
     */
    public function setIdMatch($idMatch)
    {
        $this->idMatch = $idMatch;

        return $this;
    }

    /**
     * Get idMatch
     *
     * @return string 
     */
    public function getIdMatch()
    {
        return $this->idMatch;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return ApiResultatTennis
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set nomTournois
     *
     * @param string $nomTournois
     * @return ApiResultatTennis
     */
    public function setNomTournois($nomTournois)
    {
        $this->nomTournois = $nomTournois;

        return $this;
    }

    /**
     * Get nomTournois
     *
     * @return string 
     */
    public function getNomTournois()
    {
        return $this->nomTournois;
    }

    /**
     * Set manche
     *
     * @param string $manche
     * @return ApiResultatTennis
     */
    public function setManche($manche)
    {
        $this->manche = $manche;

        return $this;
    }

    /**
     * Get manche
     *
     * @return string 
     */
    public function getManche()
    {
        return $this->manche;
    }

    /**
     * Set idTournois
     *
     * @param string $idTournois
     * @return ApiResultatTennis
     */
    public function setIdTournois($idTournois)
    {
        $this->idTournois = $idTournois;

        return $this;
    }

    /**
     * Get idTournois
     *
     * @return string 
     */
    public function getIdTournois()
    {
        return $this->idTournois;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return ApiResultatTennis
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set genre
     *
     * @param string $genre
     * @return ApiResultatTennis
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return string 
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set joueur1Id
     *
     * @param string $joueur1Id
     * @return ApiResultatTennis
     */
    public function setJoueur1Id($joueur1Id)
    {
        $this->joueur1Id = $joueur1Id;

        return $this;
    }

    /**
     * Get joueur1Id
     *
     * @return string 
     */
    public function getJoueur1Id()
    {
        return $this->joueur1Id;
    }

    /**
     * Set joueur1Nom
     *
     * @param string $joueur1Nom
     * @return ApiResultatTennis
     */
    public function setJoueur1Nom($joueur1Nom)
    {
        $this->joueur1Nom = $joueur1Nom;

        return $this;
    }

    /**
     * Get joueur1Nom
     *
     * @return string 
     */
    public function getJoueur1Nom()
    {
        return $this->joueur1Nom;
    }

    /**
     * Set joueur1Nationalite
     *
     * @param string $joueur1Nationalite
     * @return ApiResultatTennis
     */
    public function setJoueur1Nationalite($joueur1Nationalite)
    {
        $this->joueur1Nationalite = $joueur1Nationalite;

        return $this;
    }

    /**
     * Get joueur1Nationalite
     *
     * @return string 
     */
    public function getJoueur1Nationalite()
    {
        return $this->joueur1Nationalite;
    }

    /**
     * Set joueur1BracketNumber
     *
     * @param string $joueur1BracketNumber
     * @return ApiResultatTennis
     */
    public function setJoueur1BracketNumber($joueur1BracketNumber)
    {
        $this->joueur1BracketNumber = $joueur1BracketNumber;

        return $this;
    }

    /**
     * Get joueur1BracketNumber
     *
     * @return string 
     */
    public function getJoueur1BracketNumber()
    {
        return $this->joueur1BracketNumber;
    }

    /**
     * Set joueur1Qualifier
     *
     * @param string $joueur1Qualifier
     * @return ApiResultatTennis
     */
    public function setJoueur1Qualifier($joueur1Qualifier)
    {
        $this->joueur1Qualifier = $joueur1Qualifier;

        return $this;
    }

    /**
     * Get joueur1Qualifier
     *
     * @return string 
     */
    public function getJoueur1Qualifier()
    {
        return $this->joueur1Qualifier;
    }

    /**
     * Set joueur2Id
     *
     * @param string $joueur2Id
     * @return ApiResultatTennis
     */
    public function setJoueur2Id($joueur2Id)
    {
        $this->joueur2Id = $joueur2Id;

        return $this;
    }

    /**
     * Get joueur2Id
     *
     * @return string 
     */
    public function getJoueur2Id()
    {
        return $this->joueur2Id;
    }

    /**
     * Set joueur2Nom
     *
     * @param string $joueur2Nom
     * @return ApiResultatTennis
     */
    public function setJoueur2Nom($joueur2Nom)
    {
        $this->joueur2Nom = $joueur2Nom;

        return $this;
    }

    /**
     * Get joueur2Nom
     *
     * @return string 
     */
    public function getJoueur2Nom()
    {
        return $this->joueur2Nom;
    }

    /**
     * Set joueur2Nationalite
     *
     * @param string $joueur2Nationalite
     * @return ApiResultatTennis
     */
    public function setJoueur2Nationalite($joueur2Nationalite)
    {
        $this->joueur2Nationalite = $joueur2Nationalite;

        return $this;
    }

    /**
     * Get joueur2Nationalite
     *
     * @return string 
     */
    public function getJoueur2Nationalite()
    {
        return $this->joueur2Nationalite;
    }

    /**
     * Set joueur2BracketNumber
     *
     * @param string $joueur2BracketNumber
     * @return ApiResultatTennis
     */
    public function setJoueur2BracketNumber($joueur2BracketNumber)
    {
        $this->joueur2BracketNumber = $joueur2BracketNumber;

        return $this;
    }

    /**
     * Get joueur2BracketNumber
     *
     * @return string 
     */
    public function getJoueur2BracketNumber()
    {
        return $this->joueur2BracketNumber;
    }

    /**
     * Set joueur2Qualifier
     *
     * @param string $joueur2Qualifier
     * @return ApiResultatTennis
     */
    public function setJoueur2Qualifier($joueur2Qualifier)
    {
        $this->joueur2Qualifier = $joueur2Qualifier;

        return $this;
    }

    /**
     * Get joueur2Qualifier
     *
     * @return string 
     */
    public function getJoueur2Qualifier()
    {
        return $this->joueur2Qualifier;
    }

    /**
     * Set idGagnant
     *
     * @param string $idGagnant
     * @return ApiResultatTennis
     */
    public function setIdGagnant($idGagnant)
    {
        $this->idGagnant = $idGagnant;

        return $this;
    }

    /**
     * Get idGagnant
     *
     * @return string 
     */
    public function getIdGagnant()
    {
        return $this->idGagnant;
    }

    /**
     * Set scoreS1J1
     *
     * @param string $scoreS1J1
     * @return ApiResultatTennis
     */
    public function setScoreS1J1($scoreS1J1)
    {
        $this->scoreS1J1 = $scoreS1J1;

        return $this;
    }

    /**
     * Get scoreS1J1
     *
     * @return string 
     */
    public function getScoreS1J1()
    {
        return $this->scoreS1J1;
    }

    /**
     * Set scoreS1J2
     *
     * @param string $scoreS1J2
     * @return ApiResultatTennis
     */
    public function setScoreS1J2($scoreS1J2)
    {
        $this->scoreS1J2 = $scoreS1J2;

        return $this;
    }

    /**
     * Get scoreS1J2
     *
     * @return string 
     */
    public function getScoreS1J2()
    {
        return $this->scoreS1J2;
    }

    /**
     * Set scoreS2J1
     *
     * @param string $scoreS2J1
     * @return ApiResultatTennis
     */
    public function setScoreS2J1($scoreS2J1)
    {
        $this->scoreS2J1 = $scoreS2J1;

        return $this;
    }

    /**
     * Get scoreS2J1
     *
     * @return string 
     */
    public function getScoreS2J1()
    {
        return $this->scoreS2J1;
    }

    /**
     * Set scoreS2J2
     *
     * @param string $scoreS2J2
     * @return ApiResultatTennis
     */
    public function setScoreS2J2($scoreS2J2)
    {
        $this->scoreS2J2 = $scoreS2J2;

        return $this;
    }

    /**
     * Get scoreS2J2
     *
     * @return string 
     */
    public function getScoreS2J2()
    {
        return $this->scoreS2J2;
    }

    /**
     * Set scoreS3J1
     *
     * @param string $scoreS3J1
     * @return ApiResultatTennis
     */
    public function setScoreS3J1($scoreS3J1)
    {
        $this->scoreS3J1 = $scoreS3J1;

        return $this;
    }

    /**
     * Get scoreS3J1
     *
     * @return string 
     */
    public function getScoreS3J1()
    {
        return $this->scoreS3J1;
    }

    /**
     * Set scoreS3J2
     *
     * @param string $scoreS3J2
     * @return ApiResultatTennis
     */
    public function setScoreS3J2($scoreS3J2)
    {
        $this->scoreS3J2 = $scoreS3J2;

        return $this;
    }

    /**
     * Get scoreS3J2
     *
     * @return string 
     */
    public function getScoreS3J2()
    {
        return $this->scoreS3J2;
    }

    /**
     * Set scoreS4J1
     *
     * @param string $scoreS4J1
     * @return ApiResultatTennis
     */
    public function setScoreS4J1($scoreS4J1)
    {
        $this->scoreS4J1 = $scoreS4J1;

        return $this;
    }

    /**
     * Get scoreS4J1
     *
     * @return string 
     */
    public function getScoreS4J1()
    {
        return $this->scoreS4J1;
    }

    /**
     * Set scoreS4J2
     *
     * @param string $scoreS4J2
     * @return ApiResultatTennis
     */
    public function setScoreS4J2($scoreS4J2)
    {
        $this->scoreS4J2 = $scoreS4J2;

        return $this;
    }

    /**
     * Get scoreS4J2
     *
     * @return string 
     */
    public function getScoreS4J2()
    {
        return $this->scoreS4J2;
    }

    /**
     * Set scoreS5J1
     *
     * @param string $scoreS5J1
     * @return ApiResultatTennis
     */
    public function setScoreS5J1($scoreS5J1)
    {
        $this->scoreS5J1 = $scoreS5J1;

        return $this;
    }

    /**
     * Get scoreS5J1
     *
     * @return string 
     */
    public function getScoreS5J1()
    {
        return $this->scoreS5J1;
    }

    /**
     * Set scoreS5J2
     *
     * @param string $scoreS5J2
     * @return ApiResultatTennis
     */
    public function setScoreS5J2($scoreS5J2)
    {
        $this->scoreS5J2 = $scoreS5J2;

        return $this;
    }

    /**
     * Get scoreS5J2
     *
     * @return string 
     */
    public function getScoreS5J2()
    {
        return $this->scoreS5J2;
    }

    /**
     * Set resultatMatchJ1
     *
     * @param string $resultatMatchJ1
     * @return ApiResultatTennis
     */
    public function setResultatMatchJ1($resultatMatchJ1)
    {
        $this->resultatMatchJ1 = $resultatMatchJ1;

        return $this;
    }

    /**
     * Get resultatMatchJ1
     *
     * @return string 
     */
    public function getResultatMatchJ1()
    {
        return $this->resultatMatchJ1;
    }

    /**
     * Set resultatMatchJ2
     *
     * @param string $resultatMatchJ2
     * @return ApiResultatTennis
     */
    public function setResultatMatchJ2($resultatMatchJ2)
    {
        $this->resultatMatchJ2 = $resultatMatchJ2;

        return $this;
    }

    /**
     * Get resultatMatchJ2
     *
     * @return string 
     */
    public function getResultatMatchJ2()
    {
        return $this->resultatMatchJ2;
    }
}
