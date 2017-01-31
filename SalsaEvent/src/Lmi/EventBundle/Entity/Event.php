<?php

namespace Lmi\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Criteria;

/**
 * Event
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Lmi\EventBundle\Entity\EventRepository")
 */
class Event extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="identification", type="string", length=255, nullable=true)
     */
    private $identification;
    
    /**
     * @ORM\OneToMany(targetEntity="Lmi\EventBundle\Entity\Soiree", mappedBy="event", cascade={"persist", "remove", "merge"})
     */
    private $soirees; 
    
    /**
     * @ORM\OneToMany(targetEntity="Lmi\EventBundle\Entity\Stage", mappedBy="event", cascade={"persist", "remove", "merge"})
     */
    private $stages;
    
    /**
     * @ORM\ManyToMany(targetEntity="Lmi\EventBundle\Entity\DanceSchool", cascade={"persist", "remove"})
     */
    private $organisateurs;
    
    /**
     * @ORM\OneToMany(targetEntity="Lmi\EventBundle\Entity\CarPooling", mappedBy="event", cascade={"persist"})
     */
    private $carpoolings;
    
    /**
     * @ORM\ManyToMany(targetEntity="Lmi\EventBundle\Entity\Accommodation", mappedBy="events", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="event_accommodation")
     */
    private $hebergements;
    
    /**
     * @ORM\ManyToOne(targetEntity="Lmi\EventBundle\Entity\Adresse", cascade={"persist", "remove"})
     */
    private $adresse;
    
    /**
     * @ORM\OneToOne(targetEntity="Lmi\EventBundle\Entity\Image", cascade={"persist", "remove"})
     */
    private $flyer;
    
    //private $concerts
    //private $commerces
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	parent::__construct();
        $this->soirees = new \Doctrine\Common\Collections\ArrayCollection();
        $this->stages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->organisateurs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->carpoolings = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add soirees
     *
     * @param \Lmi\EventBundle\Entity\Soiree $soiree
     * @return Event
     */
    public function addSoiree(\Lmi\EventBundle\Entity\Soiree $soiree)
    {
        $this->soirees[] = $soiree;
        $soiree->setEvent($this);
    
        return $this;
    }
    
    /**
     * Remove soirees
     *
     * @param \Lmi\EventBundle\Entity\Soiree $soiree
     */
    public function removeSoiree(\Lmi\EventBundle\Entity\Soiree $soiree)
    {
        $this->soirees->removeElement($soiree);
    }

    /**
     * Get soirees
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSoirees()
    {
        return $this->soirees;
    }

    /**
     * Add stages
     *
     * @param \Lmi\EventBundle\Entity\Stage $stage
     * @return Event
     */
    public function addStage(\Lmi\EventBundle\Entity\Stage $stage)
    {
        $this->stages[] = $stage;
        $stage->setEvent($this);
    
        return $this;
    }

    /**
     * Remove stage
     *
     * @param \Lmi\EventBundle\Entity\Stage $stage
     */
    public function removeStage(\Lmi\EventBundle\Entity\Stage $stage)
    {
        $this->stages->removeElement($stage);
    }

    /**
     * Get stages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStages()
    {
        return $this->stages;
    }

    /**
     * Set identification
     *
     * @param string $identification
     * @return Event
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
     * Set adresse
     *
     * @param \Lmi\EventBundle\Entity\Adresse $adresse
     * @return Event
     */
    public function setAdresse(\Lmi\EventBundle\Entity\Adresse $adresse = null)
    {
        $this->adresse = $adresse;
    
        return $this;
    }

    /**
     * Get adresse
     *
     * @return \Lmi\EventBundle\Entity\Adresse 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set flyer
     *
     * @param \Lmi\EventBundle\Entity\Image $flyer
     * @return Event
     */
    public function setFlyer(\Lmi\EventBundle\Entity\Image $flyer = null)
    {
        $this->flyer = $flyer;
    
        return $this;
    }

    /**
     * Get flyer
     *
     * @return \Lmi\EventBundle\Entity\Image 
     */
    public function getFlyer()
    {
        return $this->flyer;
    }

    /**
     * Get desciptif
     *
     * @return string
     */
    public function getDescriptif()
    {
    	return 'descriptif';
    }
    

    /**
     * Add organisateurs
     *
     * @param \Lmi\EventBundle\Entity\DanceSchool $organisateur
     * @return Soiree
     */
    public function addOrganisateur(\Lmi\EventBundle\Entity\DanceSchool $organisateur)
    {
    	$this->organisateurs[] = $organisateur;
    	
    	return $this;
    }
    
    /**
     * Remove organisateur
     *
     * @param \Lmi\EventBundle\Entity\DanceSchool $organisateur
     */
    public function removeOrganisateur(\Lmi\EventBundle\Entity\DanceSchool $organisateur)
    {
    	$this->organisateurs->removeElement($organisateur);
    }
    
    /**
     * Get organisateurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrganisateurs()
    {
    	return $this->organisateurs;
    }
    
    /**
     * Add carpooling
     *
     * @param \Lmi\EventBundle\Entity\CarPooling $carpooling
     * @return Event
     */
    public function addCarpooling(\Lmi\EventBundle\Entity\CarPooling $carpooling)
    {
        $this->carpoolings[] = $carpooling;
        $carpooling->setEvent($this);
    
        return $this;
    }

    /**
     * Remove carpooling
     *
     * @param \Lmi\EventBundle\Entity\CarPooling $carpooling
     */
    public function removeCarpooling(\Lmi\EventBundle\Entity\CarPooling $carpooling)
    {
        $this->carpoolings->removeElement($carpooling);
    }

    /**
     * Get carpoolings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCarpoolings()
    {
        return $this->carpoolings;
    }
    
    /**
     * Get carpoolings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAvailableCarpoolings()
    {
    	$criteria = Criteria::create();
    	$criteria->where(Criteria::expr()->gte('dateDepart', new \DateTime()));
    	
    	return $this->carpoolings->matching($criteria);
    }

    /**
     * Add hebergement
     *
     * @param \Lmi\EventBundle\Entity\Accommodation $hebergement
     * @return Event
     */
    public function addHebergement(\Lmi\EventBundle\Entity\Accommodation $hebergement)
    {
        $this->hebergements[] = $hebergement;
        $hebergement->addEvent($this);
    
        return $this;
    }

    /**
     * Remove hebergements
     *
     * @param \Lmi\EventBundle\Entity\Accommodation $hebergements
     */
    public function removeHebergement(\Lmi\EventBundle\Entity\Accommodation $hebergements)
    {
        $this->hebergements->removeElement($hebergements);
    }

    /**
     * Get hebergements
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHebergements()
    {
        return $this->hebergements;
    }
    
    /**
     * Get hebergements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAvailableHebergements()
    {
    	$criteria = Criteria::create();
    	$criteria->where(Criteria::expr()->gte('periode.dateFin', new \DateTime()));
    	 
    	return $this->hebergements->matching($criteria);
    }
    
    /**
     * Get all types of music for the event
     */
    public function  getAmbiances() 
    {
    	$ambiances = array();
    	$arrSoirees = $this->soirees->toArray();
    	
    	foreach ($arrSoirees as $soiree){
    		$ambiances = array_merge($ambiances, $soiree->getAmbiances());
    	}
    	return $ambiances;
    }
    
    /**
     * Get the main organizer
     */
    public function  getMainOrganizer()
    {
    	$arrOrganizers = $this->organisateurs->toArray();
    	
    	if(count($arrOrganizers) !== 0) {
    		return $arrOrganizers[0]->getNom();
    	}
    	
    	return null;
    }
}