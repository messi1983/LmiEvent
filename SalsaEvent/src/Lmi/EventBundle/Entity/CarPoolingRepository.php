<?php

namespace Lmi\EventBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Lmi\EventBundle\Constants\ConstParamAttributs;

/**
 * CarPoolingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CarPoolingRepository extends AbstractRepository
{
	/**
	 * Find next published carpoolings dates with limit
	 * @param integer $limit
	 */
	public function findDates($limit)
	{
		$nq = $this->createNativeNamedQuery('cPoolingsDates')
					->setParameter(ConstParamAttributs::PARAM_SQL_PUBLISHED, true)
					->setParameter(ConstParamAttributs::PARAM_SQL_LIMIT, $limit);
	
		return $nq->execute();
	}
	
	/**
	 * Find entities from an event and date
	 * @param unknown $page
	 * @param unknown $nbDanceSchoolByPage
	 * @param unknown $eventId
	 */
	public function findFromEventAndDate($eventId, $date, $page, $nbCarPoolingByPage) 
	{
		$qb = $this->createQueryBuilder('c');
	
		$qb->leftJoin('c.event', 'e')
		   ->where($qb->expr()->andX(
				$qb->expr()->eq('c.publication', ':published'),
				$qb->expr()->andX(
					$qb->expr()->eq('e.id', ':eventId'),
					$qb->expr()->andX(
		   				$qb->expr()->gte('c.dateDepart', ':currentDateTime'),
		   				$qb->expr()->eq("DATE_FORMAT(c.dateDepart, '%Y-%m-%d')", ':date')
		   			)
				)
		   ));
		$qb->orderBy('c.dateDepart', 'ASC');
		$qb->setParameter(ConstParamAttributs::PARAM_SQL_EVENT_ID, $eventId);
		$qb->setParameter(ConstParamAttributs::PARAM_SQL_PUBLISHED, true);
		$qb->setParameter('currentDateTime', new \DateTime());
		$qb->setParameter('date', $date);
	
		return $this->buildPaginator($qb->getQuery(), $page, $nbCarPoolingByPage);
	}
	
	/**
	 * Find entities from a date
	 * @param unknown $page
	 * @param unknown $nbDanceSchoolByPage
	 * @param unknown $eventId
	 */
	public function findFromDate($date, $page, $nbCarPoolingByPage) 
	{
		$qb = $this->createQueryBuilder('c');
		
		$qb->leftJoin('c.event', 'e')
		   ->where($qb->expr()->andX(
				$qb->expr()->eq('c.publication', ':published'),
		   		$qb->expr()->andX(
		   			$qb->expr()->gte('c.dateDepart', ':currentDateTime'),
		   			$qb->expr()->eq("DATE_FORMAT(c.dateDepart, '%Y-%m-%d')", ':date')
		   		)
			));
		$qb->orderBy('c.dateDepart', 'ASC');
		$qb->setParameter(ConstParamAttributs::PARAM_SQL_PUBLISHED, true);
		$qb->setParameter('currentDateTime', new \DateTime());
		$qb->setParameter('date', $date);
	
		return $this->buildPaginator($qb->getQuery(), $page, $nbCarPoolingByPage);
	}
	
}