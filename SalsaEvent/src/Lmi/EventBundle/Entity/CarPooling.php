<?php

namespace Lmi\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CarPooling
 * 
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Lmi\EventBundle\Entity\CarPoolingRepository")
 */
class CarPooling extends AbstractEntity
{
	/**
	 * @ORM\ManyToOne(targetEntity="Lmi\EventBundle\Entity\User", cascade={"persist", "merge"})
	 */
	private $driver;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Lmi\EventBundle\Entity\User", inversedBy="carpoolings", cascade={"persist", "remove", "merge"})
	 * @ORM\JoinTable(name="user_carpooling")
	 */
	private $carpoolers;
	
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="nbPlaces", type="integer")
	 */
	private $nbPlaces;
	
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDepart", type="datetime")
     */
    private $dateDepart;
    
    /**
     * @ORM\ManyToOne(targetEntity="Lmi\EventBundle\Entity\Trajet", cascade={"persist", "remove"})
     */
    private $trajet;
    
    /**
     * @ORM\ManyToOne(targetEntity="Lmi\EventBundle\Entity\Event", inversedBy="covoiturages", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $event;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	parent::__construct();
    }
    
    /**
     * Set dateDepart
     *
     * @param \DateTime $dateDepart
     * @return CarPooling
     */
    public function setDateDepart($dateDepart)
    {
        $this->dateDepart = $dateDepart;
    
        return $this;
    }

    /**
     * Get dateDepart
     *
     * @return \DateTime 
     */
    public function getDateDepart()
    {
        return $this->dateDepart;
    }

    /**
     * Set trajet
     *
     * @param \Lmi\EventBundle\Entity\Trajet $trajet
     * @return CarPooling
     */
    public function setTrajet(\Lmi\EventBundle\Entity\Trajet $trajet = null)
    {
        $this->trajet = $trajet;
    
        return $this;
    }

    /**
     * Get trajet
     *
     * @return \Lmi\EventBundle\Entity\Tajet 
     */
    public function getTrajet()
    {
        return $this->trajet;
    }

    /**
     * Set nbPlaces
     *
     * @param integer $nbPlaces
     * @return CarPooling
     */
    public function setNbPlaces($nbPlaces)
    {
        $this->nbPlaces = $nbPlaces;
    
        return $this;
    }

    /**
     * Get nbPlaces
     *
     * @return integer 
     */
    public function getNbPlaces()
    {
        return $this->nbPlaces;
    }

    /**
     * Set driver
     *
     * @param \Lmi\EventBundle\Entity\User $driver
     * @return CarPooling
     */
    public function setDriver(\Lmi\EventBundle\Entity\User $driver = null)
    {
    	// update passengers list
    	if($this->driver !== null) {
    		$this->removePassenger($this->driver);
    	}
    	
        $this->driver = $driver;
        
        // The driver is the first passenger
        $this->addCarpooler($driver);
    
        return $this;
    }

    /**
     * Get driver
     *
     * @return \Lmi\EventBundle\Entity\User 
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Add carpooler
     *
     * @param \Lmi\EventBundle\Entity\User $carpooler
     * @return CarPooling
     */
    public function addCarpooler(\Lmi\EventBundle\Entity\User $carpooler)
    {
        $this->carpoolers[] = $carpooler;
    
        return $this;
    }

    /**
     * Remove carpooler
     *
     * @param \Lmi\EventBundle\Entity\User $carpooler
     */
    public function removeCarpooler(\Lmi\EventBundle\Entity\User $carpooler)
    {
        $this->carpoolers->removeElement($carpooler);
    }

    /**
     * Get $carpoolers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCarpoolers()
    {
        return $this->carpoolers;
    }

    /**
     * Set event
     *
     * @param \Lmi\EventBundle\Entity\Event $event
     * @return CarPooling
     */
    public function setEvent(\Lmi\EventBundle\Entity\Event $event = null)
    {
        $this->event = $event;
    
        return $this;
    }

    /**
     * Get event
     *
     * @return \Lmi\EventBundle\Entity\Event 
     */
    public function getEvent()
    {
        return $this->event;
    }

}