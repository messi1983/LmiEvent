<?php
namespace Lmi\EventBundle\Services;
use Doctrine\ORM\EntityManager;
use Lmi\EventBundle\Constants\Constants;
use Lmi\EventBundle\Entity\Periode;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * Store service class
 */
class StoreService
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
	 * @return multitype:
	 */
	public function findAllPublished($page, $nbDanceSchoolByPage) {
		return $this->em->getRepository(Constants::CLASS_STORE)->findAllPublished($page, $nbDanceSchoolByPage);
	}
	
}
?>
