<?php

namespace Lmi\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 */
class User extends BaseUser
{
   /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
	protected $id;
	
	/**
	 * @var string $lastname
	 *
	 * @ORM\Column(name="lastname", type="string", length=255)
	 */
	private $lastname;
	
	/**
	 * @var string $firstname
	 *
	 * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
	 */
	private $firstname;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="type", type="string", columnDefinition="enum('M', 'F')")
	 */
	private $sexe;
	
	/**
	 * @var ArrayCollection $carpoolings
	 * 
	 * @ORM\ManyToMany(targetEntity="Lmi\EventBundle\Entity\CarPooling", mappedBy="carpoolers", cascade={"persist", "remove", "merge"})
	 * @ORM\JoinTable(name="user_carpooling")
	 */
	private $carpoolings;
	
	/**
	 * @var ArrayCollection $accommodations
	 *
	 * @ORM\ManyToMany(targetEntity="Lmi\EventBundle\Entity\Accommodation", mappedBy="passengers", cascade={"persist", "remove", "merge"})
	 * @ORM\JoinTable(name="user_accommodation")
	 */
	private $accommodations;
	
	/**
	 * @ORM\OneToOne(targetEntity="Lmi\EventBundle\Entity\BankAccount", cascade={"persist", "remove", "merge"})
	 */
	private $bankAccount;
	
	/**
	 * @ORM\OneToOne(targetEntity="Lmi\EventBundle\Entity\CarInfos", cascade={"persist", "remove", "merge"})
	 */
	private $carInfos;

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
     * Set sexe
     *
     * @param string $sexe
     * @return User
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

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
    	parent::__construct();
        $this->carpoolings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->accommodations = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add carpoolings
     *
     * @param \Lmi\EventBundle\Entity\CarPooling $carpoolings
     * @return User
     */
    public function addCarpooling(\Lmi\EventBundle\Entity\CarPooling $carpoolings)
    {
        $this->carpoolings[] = $carpoolings;
    
        return $this;
    }

    /**
     * Remove carpoolings
     *
     * @param \Lmi\EventBundle\Entity\CarPooling $carpoolings
     */
    public function removeCarpooling(\Lmi\EventBundle\Entity\CarPooling $carpoolings)
    {
        $this->carpoolings->removeElement($carpoolings);
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
     * Add accommodations
     *
     * @param \Lmi\EventBundle\Entity\Accommodation $accommodations
     * @return User
     */
    public function addAccommodation(\Lmi\EventBundle\Entity\Accommodation $accommodations)
    {
        $this->accommodations[] = $accommodations;
    
        return $this;
    }

    /**
     * Remove accommodations
     *
     * @param \Lmi\EventBundle\Entity\Accommodation $accommodations
     */
    public function removeAccommodation(\Lmi\EventBundle\Entity\Accommodation $accommodations)
    {
        $this->accommodations->removeElement($accommodations);
    }

    /**
     * Get accommodations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAccommodations()
    {
        return $this->accommodations;
    }

    /**
     * Set bankAccount
     *
     * @param \Lmi\EventBundle\Entity\BankAccount $bankAccount
     * @return User
     */
    public function setBankAccount(\Lmi\EventBundle\Entity\BankAccount $bankAccount = null)
    {
        $this->bankAccount = $bankAccount;
    
        return $this;
    }

    /**
     * Get bankAccount
     *
     * @return \Lmi\EventBundle\Entity\BankAccount 
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    /**
     * Set carInfos
     *
     * @param \Lmi\EventBundle\Entity\CarInfos $carInfos
     * @return User
     */
    public function setCarInfos(\Lmi\EventBundle\Entity\CarInfos $carInfos = null)
    {
        $this->carInfos = $carInfos;
    
        return $this;
    }

    /**
     * Get carInfos
     *
     * @return \Lmi\EventBundle\Entity\CarInfos 
     */
    public function getCarInfos()
    {
        return $this->carInfos;
    }
}