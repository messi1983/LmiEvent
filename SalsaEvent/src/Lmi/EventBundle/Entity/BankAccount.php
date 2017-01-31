<?php

namespace Lmi\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BankAccount
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class BankAccount
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
     * @ORM\Column(name="holder", type="string", length=255)
     */
    private $holder;

    /**
     * @var string
     *
     * @ORM\Column(name="IBAN", type="string", length=255)
     */
    private $iBAN;

    /**
     * @var string
     *
     * @ORM\Column(name="BIC", type="string", length=255)
     */
    private $bIC;


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
     * Set holder
     *
     * @param string $holder
     * @return BankAccount
     */
    public function setHolder($holder)
    {
        $this->holder = $holder;
    
        return $this;
    }

    /**
     * Get holder
     *
     * @return string 
     */
    public function getHolder()
    {
        return $this->holder;
    }

    /**
     * Set iBAN
     *
     * @param string $iBAN
     * @return BankAccount
     */
    public function setIBAN($iBAN)
    {
        $this->iBAN = $iBAN;
    
        return $this;
    }

    /**
     * Get iBAN
     *
     * @return string 
     */
    public function getIBAN()
    {
        return $this->iBAN;
    }

    /**
     * Set bIC
     *
     * @param string $bIC
     * @return BankAccount
     */
    public function setBIC($bIC)
    {
        $this->bIC = $bIC;
    
        return $this;
    }

    /**
     * Get bIC
     *
     * @return string 
     */
    public function getBIC()
    {
        return $this->bIC;
    }
}
