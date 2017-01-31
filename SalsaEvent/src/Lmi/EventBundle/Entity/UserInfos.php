<?php

namespace Lmi\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Will contain User informations for search form
 *
 */
class UserInfos
{
	/**
	 * @var string
	 */
	private $nom;
	
	/**
	 * @var string
	 */
	private $sexe;
    
    /**
     * Add $identification
     *
     * @param string $nom
     * @return SearchDanceSchool
     */
    public function setNom($nom)
    {
    	$this->nom = $nom;
    
    	return $this;
    }
    
    /**
     * Get $nom
     *
     * @return string
     */
    public function getNom()
    {
    	return $this->nom;
    }
    
    /**
     * Set sexe
     *
     * @param string $sexe
     * @return DriverInfos
     */
    public function setSexe($sexe)
    {
    	$this->sexe = $sexe;
    
    	return $this;
    }
    
    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
    	return $this->sexe;
    }
    
}
