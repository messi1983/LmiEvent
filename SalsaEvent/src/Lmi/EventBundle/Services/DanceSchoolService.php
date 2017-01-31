<?php
namespace Lmi\EventBundle\Services;
use Doctrine\ORM\EntityManager;
use Lmi\EventBundle\Entity\Periode;
use Doctrine\ORM\Query\ResultSetMapping;
use Lmi\EventBundle\Entity\DanceSchool;
use Lmi\EventBundle\Constants\ConstClasses;

/**
 * Dance School service class
 */
class DanceSchoolService
{
	/**
	 * Entity manager
	 */
	protected $em;
	
	/**
	 * Constructor
	 */
	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}
	
	/**
	 * All published dance school registered
	 * @param $page
	 * @param $nbDanceSchoolByPage
	 * @return list of DanceSchool
	 */
	public function findAllDanceSchools($page, $nbDanceSchoolByPage) {
		return $this->getLinkedRepository()->findAllDanceSchools($page, $nbDanceSchoolByPage);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Lmi\EventBundle\Services\AbstractService::getLinkedRepository()
	 */
	protected function getLinkedRepository()
	{
		return $this->em->getRepository(ConstClasses::CLASS_DANCE_SCHOOL);
	}
	
}
?>
