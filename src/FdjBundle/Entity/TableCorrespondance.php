<?php

namespace FdjBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TableCorrespondance
 *
 * @ORM\Table(name="table_correspondance")
 * @ORM\Entity(repositoryClass="FdjBundle\Repository\TableCorrespondanceRepository")
 */
class TableCorrespondance
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
     * @ORM\Column(name="sportRadar", type="string", length=255, nullable=true)
     */
    private $sportRadar;

    /**
     * @var string
     *
     * @ORM\Column(name="IdSportRadar", type="string", length=255, nullable=true)
     */
    private $idSportRadar;

    /**
     * @var string
     *
     * @ORM\Column(name="importScraper", type="string", length=255, nullable=true)
     */
    private $importScraper;


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
     * Set sportRadar
     *
     * @param string $sportRadar
     * @return TableCorrespondance
     */
    public function setSportRadar($sportRadar)
    {
        $this->sportRadar = $sportRadar;

        return $this;
    }

    /**
     * Get sportRadar
     *
     * @return string 
     */
    public function getSportRadar()
    {
        return $this->sportRadar;
    }

    /**
     * Set importScraper
     *
     * @param string $importScraper
     * @return TableCorrespondance
     */
    public function setImportScraper($importScraper)
    {
        $this->importScraper = $importScraper;

        return $this;
    }

    /**
     * Get importScraper
     *
     * @return string 
     */
    public function getImportScraper()
    {
        return $this->importScraper;
    }

    /**
     * @return string
     */
    public function getIdSportRadar()
    {
        return $this->idSportRadar;
    }

    /**
     * @param string $idSportRadar
     */
    public function setIdSportRadar($idSportRadar)
    {
        $this->idSportRadar = $idSportRadar;
    }
}
