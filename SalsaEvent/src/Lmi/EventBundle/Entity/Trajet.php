<?php

namespace Lmi\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lmi\EventBundle\Constants\Constants;

/**
 * Periode
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Trajet
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
     * @ORM\Column(name="villeDepart", type="string", length=255, nullable=false)
     */
    private $villeDepart;

    /**
     * @var string
     *
     * @ORM\Column(name="villeArrivee", type="string", length=255, nullable=false)
     */
    private $villeArrivee;
    
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
     * Set villeDepart
     *
     * @param string $villeDepart
     * @return Trajet
     */
    public function setVilleDepart($villeDepart)
    {
        $this->villeDepart = $villeDepart;
    
        return $this;
    }

    /**
     * Get string
     *
     * @return string 
     */
    public function getVilleDepart()
    {
        return $this->villeDepart;
    }

    /**
     * Set villeArrivee
     *
     * @param string $villeArrivee
     * @return Trajet
     */
    public function setVilleArrivee($villeArrivee)
    {
        $this->villeArrivee = $villeArrivee;
    
        return $this;
    }

    /**
     * Get string
     *
     * @return string 
     */
    public function getVilleArrivee()
    {
        return $this->villeArrivee;
    }
    
}
