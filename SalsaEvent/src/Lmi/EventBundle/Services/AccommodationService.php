<?php
namespace Lmi\EventBundle\Services;
use Doctrine\ORM\EntityManager;
use Lmi\EventBundle\Constants\Constants;
use Lmi\EventBundle\Entity\Periode;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * Accommodation service class
 */
class AccommodationService extends AbstractPropositionService
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
				$queryName = 'accommodationsDates_1';
				break;
	
			default:
				$queryName = 'accommodationsDates_2';
		}
		return $queryName;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Lmi\EventBundle\Services\AbstractService::getLinkedRepository()
	 */
	protected function getLinkedRepository()
	{
		return $this->em->getRepository(Constants::CLASS_ACCOMMODATION);
	}
	
}
?>
