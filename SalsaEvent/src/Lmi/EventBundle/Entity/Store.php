<?php

namespace Lmi\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lmi\EventBundle\Constants\Constants;

/**
 * Store
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Lmi\EventBundle\Entity\StoreRepository")
 */
class Store
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=60)
     */
    private $nom;
    
    /**
     * @var simple_array
     *
     * @ORM\Column(name="equipementTypes", type="simple_array", nullable=true)
     */
    private $equipementTypes;
    
    /**
     * @var simple_array
     *
     * @ORM\Column(name="domaines", type="simple_array", nullable=true)
     */
    private $domaines;
    
    /**
     * @ORM\OneToOne(targetEntity="Lmi\EventBundle\Entity\Adresse", cascade={"persist", "remove"})
     */
    private $adresse;

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
     * @return Store
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
     * Set equipementTypes
     *
     * @param array $equipementTypes
     * @return Store
     */
    public function setEquipementTypes($equipementTypes)
    {
        $this->equipementTypes = $equipementTypes;
    
        return $this;
    }

    /**
     * Get equipementTypes
     *
     * @return array 
     */
    public function getEquipementTypes()
    {
        return $this->equipementTypes;
    }

    /**
     * Set domaines
     *
     * @param array $domaines
     * @return Store
     */
    public function setDomaines($domaines)
    {
        $this->domaines = $domaines;
    
        return $this;
    }

    /**
     * Get domaines
     *
     * @return array 
     */
    public function getDomaines()
    {
        return $this->domaines;
    }

    /**
     * Set adresse
     *
     * @param \Lmi\EventBundle\Entity\Adresse $adresse
     * @return Store
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
}