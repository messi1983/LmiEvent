<?php

namespace Lmi\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DanceSchool
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Lmi\EventBundle\Entity\DanceSchoolRepository")
 */
class DanceSchool extends AbstractEntity
{

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=20)
     */
    private $type;
    
    /**
     * @ORM\OneToOne(targetEntity="Lmi\EventBundle\Entity\Adresse", cascade={"persist", "remove"})
     */
    private $adresse;
    
    /**
     * @ORM\OneToOne(targetEntity="Lmi\EventBundle\Entity\Contacts", cascade={"persist", "remove"})
     */
    private $contacts;
    
    /**
     * @var array
     *
     * @ORM\Column(name="danses", type="simple_array", nullable=true)
     */
    private $danses;
    
    /**
     * @ORM\OneToOne(targetEntity="Lmi\EventBundle\Entity\Image", cascade={"persist", "remove"})
     */
    private $logo;


    /**
     * Constructor
     */
    public function __construct()
    {
    	parent::__construct();
    	$this->danses = array();
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
     * Set nom
     *
     * @param string $nom
     * @return DanceSchool
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    
        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return DanceSchool
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
     * Set adresse
     *
     * @param \Lmi\EventBundle\Entity\Adresse $adresse
     * @return DanceSchool
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
     * Set contacts
     *
     * @param \Lmi\EventBundle\Entity\Contacts $contacts
     * @return DanceSchool
     */
    public function setContacts(\Lmi\EventBundle\Entity\Contacts $contacts = null)
    {
        $this->contacts = $contacts;
    
        return $this;
    }

    /**
     * Get contacts
     *
     * @return \Lmi\EventBundle\Entity\Contacts 
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Add danses
     *
     * @param string $danse
     * @return DanceSchool
     */
    public function addDanse($danse)
    {
        $this->danses[] = $danse;
    
        return $this;
    }

    /**
     * Remove dansesEnsignees
     *
     * @param string $danse
     */
    public function removeDansesEnsignee($danse)
    {
    	array_splice($this->danses, array_search($this->danses, $danse), 1);
    }

    /**
     * Get dansesEnsignees
     *
     * @return array
     */
    public function getDanses()
    {
        return $this->danses;
    }

    /**
     * Set logo
     *
     * @param \Lmi\EventBundle\Entity\Image $logo
     * @return DanceSchool
     */
    public function setLogo(\Lmi\EventBundle\Entity\Image $logo = null)
    {
        $this->logo = $logo;
    
        return $this;
    }

    /**
     * Get logo
     *
     * @return \Lmi\EventBundle\Entity\Image 
     */
    public function getLogo()
    {
        return $this->logo;
    }
}