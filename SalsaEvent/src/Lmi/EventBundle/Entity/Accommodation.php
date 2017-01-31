<?php

namespace Lmi\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Accommodation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Lmi\EventBundle\Entity\AccommodationRepository")
 */
class Accommodation extends AbstractEntity
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="nbPlaces", type="integer")
	 */
	private $nbPlaces;
    
    /**
     * @ORM\ManyToOne(targetEntity="Lmi\EventBundle\Entity\Periode", cascade={"persist", "remove"})
     */
    private $periode;
    
     /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=75, nullable=true)
     */
    private $type;
    
    /**
     * @ORM\ManyToOne(targetEntity="Lmi\EventBundle\Entity\User", inversedBy="accommodations", cascade={"persist", "merge"})
     */
    private $host;
    
    /**
     * @ORM\ManyToMany(targetEntity="Lmi\EventBundle\Entity\User", cascade={"persist", "remove"})
     */
    private $tenants;
    
    /**
     * @ORM\ManyToOne(targetEntity="Lmi\EventBundle\Entity\Adresse", cascade={"persist", "remove"})
     */
    private $adresse;
    
    /**
     * @ORM\ManyToMany(targetEntity="Lmi\EventBundle\Entity\Event", inversedBy="hebergements")
     * @ORM\JoinTable(name="event_accommodation")
     */
    private $events;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Set type
     *
     * @param string $type
     * @return Accommodation
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
     * Set periode
     *
     * @param \Lmi\EventBundle\Entity\Periode $periode
     * @return Accommodation
     */
    public function setPeriode(\Lmi\EventBundle\Entity\Periode $periode = null)
    {
        $this->periode = $periode;
    
        return $this;
    }

    /**
     * Get periode
     *
     * @return \Lmi\EventBundle\Entity\Periode 
     */
    public function getPeriode()
    {
        return $this->periode;
    }

    /**
     * Set adresse
     *
     * @param \Lmi\EventBundle\Entity\Adresse $adresse
     * @return Accommodation
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
     * Set nbPlaces
     *
     * @param integer $nbPlaces
     * @return Accommodation
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
     * Set host
     *
     * @param \Lmi\EventBundle\Entity\User $host
     * @return Accommodation
     */
    public function setHost(\Lmi\EventBundle\Entity\User $host = null)
    {
        $this->host = $host;
    
        return $this;
    }

    /**
     * Get host
     *
     * @return \Lmi\EventBundle\Entity\User 
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Add tenants
     *
     * @param \Lmi\EventBundle\Entity\User $tenant
     * @return Accommodation
     */
    public function addTenant(\Lmi\EventBundle\Entity\User $tenant)
    {
        $this->tenants[] = $tenant;
    
        return $this;
    }

    /**
     * Remove tenants
     *
     * @param \Lmi\EventBundle\Entity\User $tenant
     */
    public function removeTenant(\Lmi\EventBundle\Entity\User $tenant)
    {
        $this->tenants->removeElement($tenant);
    }
    
    /**
     * Get tenants
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTenants()
    {
        return $this->tenants;
    }

    /**
     * Add event
     *
     * @param \Lmi\EventBundle\Entity\Event $event
     * @return Accommodation
     */
    public function addEvent(\Lmi\EventBundle\Entity\Event $event)
    {
        $this->events[] = $event;
    
        return $this;
    }

    /**
     * Remove event
     *
     * @param \Lmi\EventBundle\Entity\Event $event
     */
    public function removeEvent(\Lmi\EventBundle\Entity\Event $event)
    {
        $this->events->removeElement($event);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvents()
    {
        return $this->events;
    }
}