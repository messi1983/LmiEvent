<?php
namespace Lmi\EventBundle\Services;
use Doctrine\ORM\EntityManager;
use Lmi\EventBundle\Constants\Constants;
use Lmi\EventBundle\Constants\ConstParamAttributs;
use Lmi\EventBundle\Constants\ConstClasses;
use Lmi\EventBundle\Entity\Date;
use Doctrine\ORM\Query\ResultSetMapping;
use Lmi\EventBundle\Outils\DateOutils;

/**
 * Abstract service class
 */
abstract class  AbstractService
{	
	/**
	 * Entity manager
	 */
	protected $em;
	
	/**
	 * Date repository.
	 */
	protected $dateRepository;
	
	/**
	 * Constructor
	 */
	public function __construct(EntityManager $em)
	{
		$this->em = $em;
		$this->dateRepository = $em->getRepository(ConstClasses::CLASS_DATE);
	}
	
	/**
	 * Find next published events dates with limit
	 * @param integer $limit
	 */
	public function findDates($limit)
	{
		$queryName = $this->getQueryName(1);
		$parametres = array(ConstParamAttributs::PARAM_SQL_PUBLISHED  => true, ConstParamAttributs::PARAM_SQL_LIMIT => $limit);
		
		return DateOutils::replaceOldDatesByCurrentDate($this->dateRepository->executeQuery($queryName, $parametres));
	}

	/**
	 * Find published entities.
	 * @param \Datetime $date
	 * @param unknown $page
	 * @param unknown $nbEntitiesByPage
	 * @return published entities.
	 */
	public function findFromDate($date, $page, $nbEntitiesByPage) 
	{
		if($date <= date(Constants::DEFAULT_DATE_FORMAT)) {
			return  $this->getLinkedRepository()->findFromCurrentDay($page, $nbEntitiesByPage);
		}
		return $this->getLinkedRepository()->findFromDate($date, $page, $nbEntitiesByPage);
	}
	
	/**
	 * Get query name since query number
	 * @param unknown $noQuery
	 */
	protected abstract function getQueryName($noQuery);
	
	/**
	 * Build result set mapping for date
	 */
	protected function buildDateResultSetMapping()
	{
		$rsm = new \Doctrine\ORM\Query\ResultSetMapping;
		$rsm->addEntityResult(ConstClasses::CLASS_DATE, 'd');
		$rsm->addFieldResult('d','dt','date');
	
		return $rsm;
	}
	
	/** 
	 * Get the linked repository.
	 */
	protected abstract function getLinkedRepository();
}
?>
