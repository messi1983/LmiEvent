<?php

namespace Lmi\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;

/**
 * Abstract base class for most Getin entities.
 * 
 * @MappedSuperclass
 *
 */
abstract class AbstractEntity
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
	
}
