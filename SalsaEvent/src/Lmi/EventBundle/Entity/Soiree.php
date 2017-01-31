<?php

namespace Lmi\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Soiree
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Soiree extends CommonStageSoiree
{
    /**
     * @var string
     *
     * @ORM\Column(name="identification", type="string", length=255)
     */
    private $identification;
    
    /**
     * @var string
     *
     * @ORM\Column(name="programme", type="string", length=255)
     */
    private $programme;
    
    /**
     * @var array
     *
     * @ORM\Column(name="ambiances", type="simple_array", nullable=true)
     */
    private $ambiances;
    
//     private $services;

//     private $animateurs;

//     private $intentions;

    /**
     * Constructor
     */
    public function __construct()
    {
    	parent::__construct();
    	$this->ambiances = array();
    }
    
    /**
     * Set programme
     *
     * @param string $programme
     * @return Soiree
     */
    public function setProgramme($programme)
    {
        $this->programme = $programme;
    
        return $this;
    }

    /**
     * Get programme
     *
     * @return string 
     */
    public function getProgramme()
    {
        return $this->programme;
    }
    
    /**
     * Set identification
     *
     * @param string $identification
     * @return Soiree
     */
    public function setIdentification($identification)
    {
        $this->identification = $identification;
    
        return $this;
    }

    /**
     * Get identification
     *
     * @return string 
     */
    public function getIdentification()
    {
        return $this->identification;
    }

    /**
     * Add ambiance
     *
     * @param string $ambiance
     * @return Soiree
     */
    public function addAmbiance($ambiance)
    {
        $this->ambiances[] = $ambiance;
    
        return $this;
    }

    /**
     * Remove ambiances
     *
     * @param string $ambiance
     */
    public function removeAmbiance($ambiance)
    {
    	array_splice($this->ambiances, array_search($this->ambiances, $ambiance), 1);
    }

    /**
     * Get ambiances
     *
     * @return array
     */
    public function getAmbiances()
    {
        return $this->ambiances;
    }

    /**
     * Set ambiances
     *
     * @param array $ambiances
     * @return Soiree
     */
    public function setAmbiances($ambiances)
    {
        $this->ambiances = $ambiances;
    
        return $this;
    }
}