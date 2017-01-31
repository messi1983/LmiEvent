<?php

namespace Lmi\EventBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Lmi\EventBundle\Outils\DateOutils;
use Lmi\EventBundle\Constants\ConstParamAttributs;
use Lmi\EventBundle\Constants\ConstClasses;

/**
 * AccommodationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AccommodationRepository extends AbstractRepository
{
	/**
	 * Find next published events dates with limit
	 * @param integer $limit
	 */
	public function findDates($limit)
	{
		$nq = $this->createNativeNamedQuery('accommodationsDates')
		->setParameter(ConstParamAttributs::PARAM_SQL_PUBLISHED, true)
		->setParameter(ConstParamAttributs::PARAM_SQL_LIMIT, $limit);
	
		return $nq->execute();
	}
	
	/**
	 * Find entities from an event and date
	 * @param unknown $page
	 * @param unknown $nbAccByPage
	 * @param unknown $eventId
	 */
	public function findFromEventAndDate($eventId, $date, $page, $nbAccByPage) 
	{
		$dateTimeDebutMax = DateOutils::createMaxDateTime($date);
		$qb = $this->createQueryBuilder('a');
	
		$qb->leftJoin('a.events', 'e')
		   ->leftJoin('a.periode', 'p')
		   ->where($qb->expr()->andX(
				$qb->expr()->eq('a.publication', ':published'),
				$qb->expr()->andX(
					$qb->expr()->eq('e.id', ':eventId'),
					$qb->expr()->andX(
						$qb->expr()->gte('p.dateFin', ':date'),
						$qb->expr()->lte('p.dateDebut', ':dateTimeDebutMax')
					)
				)
		     )
		 )
		->orderBy('p.dateDebut', 'DESC')
		->setParameter(ConstParamAttributs::PARAM_SQL_PUBLISHED, true)
		->setParameter(ConstParamAttributs::PARAM_SQL_EVENT_ID, $eventId)
		->setParameter('date', $date)
		->setParameter('dateTimeDebutMax', $dateTimeDebutMax)
		;
	
		return $this->buildPaginator($qb->getQuery(), $page, $nbAccByPage);
	}
	
	/**
	 * Find entities from a date
	 * @param unknown $page
	 * @param unknown $nbAccByPage
	 */
	public function findFromDate($date, $page, $nbAccByPage) 
	{
		$dateTimeDebutMax = DateOutils::createMaxDateTime($date);
		$qb = $this->createQueryBuilder('a');
	
		$qb->leftJoin('a.events', 'e')
		->leftJoin('a.periode', 'p')
		->where($qb->expr()->andX(
				$qb->expr()->eq('a.publication', ':published'),
				$qb->expr()->andX(
					$qb->expr()->gte('p.dateFin', ':date'),
					$qb->expr()->lte('p.dateDebut', ':dateTimeDebutMax')
				)
		  ))
		->orderBy('p.dateDebut', 'DESC')
		->setParameter(ConstParamAttributs::PARAM_SQL_PUBLISHED, true)
		->setParameter('date', $date)
		->setParameter('dateTimeDebutMax', $dateTimeDebutMax)
		;
	
		return $this->buildPaginator($qb->getQuery(), $page, $nbAccByPage);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Lmi\EventBundle\Services\AbstractService::getLinkedRepository()
	 */
	protected function getLinkedRepository()
	{
		return $this->em->getRepository(ConstClasses::CLASS_ACCOMMODATION);
	}
}
