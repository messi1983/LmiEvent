<?php

namespace Lmi\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Lmi\EventBundle\Constants\Constants;

/**
 * Abstract base class for most Getin entities.
 * 
 * @MappedSuperclass
 *
 */
abstract class CommonEntity
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
	 * @var boolean
	 *
	 * @ORM\Column(name="publication", type="boolean")
	 */
	private $publication;
	
	/**
	 * @var string
	 */
	private $locale;
	
	/**
	 * @ORM\OneToOne(targetEntity="Lmi\EventBundle\Entity\Image", cascade={"persist", "remove"})
	 */
	private $logo;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->publication = false;
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
	 * Set publication
	 *
	 * @param boolean $publication
	 * @return Danse
	 */
	public function setPublication($publication)
	{
		$this->publication = $publication;
	
		return $this;
	}
	
	/**
	 * Get publication
	 *
	 * @return boolean
	 */
	public function getPublication()
	{
		return $this->publication;
	}
	
	/**
	 *
	 * @param unknown $locale
	 * @return \Lmi\EventBundle\Entity\Ecole
	 */
	public function setLocale($locale) {
		$this->locale = $locale;
	
		return $this;
	}
	
	/**
	 * Get locale
	 *
	 * @return string
	 */
	public function getLocale()
	{
		return $this->locale;
	}
	
	/**
	 * Get refence page name.
	 *
	 * @return string
	 */
	abstract public function getReferencePageName();
	
	/**
	 * Get publish option value.
	 *
	 * @return string
	 */
	public function isYes()
	{
		return true;
	}
	
	/**
	 * Get Texte string
	 */
	protected function getTexteString(\Lmi\EventBundle\Entity\Texte $texte = null) {
		$this->setTexteLocale($texte);
		
		if($texte !== null) {
			return $texte->getTexte();
		}
		return Constants::EMPTY_STRING;
	}
	
	/**
	 * Set Texte locale
	 * @param \Lmi\EventBundle\Entity\Texte $texte
	 */
	private function setTexteLocale(\Lmi\EventBundle\Entity\Texte $texte = null) {
		if($texte !== null) {
			$texte->setLocale($this->getLocale());
		}
		return $this;
	}
}
