<?php

namespace Lmi\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lmi\EventBundle\Constants\Constants;

/**
 * Adresse
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Lmi\EventBundle\Entity\EquipmentRepository")
 */
class Equipment
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
     * @var string
     *
     * @ORM\Column(name="type", type="string", columnDefinition="enum('C', 'V')")
     */
    private $type;
    
    /**
     * @ORM\OneToOne(targetEntity="Lmi\EventBundle\Entity\Image", cascade={"persist", "remove"})
     */
    private $image;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="prix", type="integer")
     */
    private $prix;

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
     * @return Equipment
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
     * @return Equipment
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
     * Set prix
     *
     * @param integer $prix
     * @return Equipment
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    
        return $this;
    }

    /**
     * Get prix
     *
     * @return integer 
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set image
     *
     * @param \Lmi\EventBundle\Entity\Image $image
     * @return Equipment
     */
    public function setImage(\Lmi\EventBundle\Entity\Image $image = null)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return \Lmi\EventBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }
}