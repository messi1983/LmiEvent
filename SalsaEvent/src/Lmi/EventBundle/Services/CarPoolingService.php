<?php
namespace Lmi\EventBundle\Services;
use Doctrine\ORM\EntityManager;
use Lmi\EventBundle\Constants\Constants;
use Lmi\EventBundle\Entity\Periode;
use Doctrine\ORM\Query\ResultSetMapping;
use Lmi\EventBundle\Constants\ConstClasses;

/**
 * CarPoolingService service class
 */
class CarPoolingService extends AbstractPropositionService
{
	/**
	 * Constructor
	 */
	public function __construct(EntityManager $em)
	{
		parent::__construct($em);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Lmi\EventBundle\Services\AbstractService::getQueryName()
	 */
	protected function getQueryName($noQuery)
	{
		$queryName = null;
		switch ($noQuery)
		{
			case 1:
				$queryName = 'carPoolingsDates_1';
				break;
	
			default:
				$queryName = 'carPoolingsDates_2';
		}
		return $queryName;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Lmi\EventBundle\Services\AbstractService::getLinkedRepository()
	 */
	protected function getLinkedRepository()
	{
		return $this->em->getRepository(ConstClasses::CLASS_CAR_POOLING);
	}
}
?>
