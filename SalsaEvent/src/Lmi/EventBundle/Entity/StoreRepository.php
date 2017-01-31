<?php

namespace Lmi\EventBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * StoreRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StoreRepository extends EntityRepository
{
	/**
	 * Find all published dance school
	 * @param $page
	 * @param $nbDanceSchoolByPage
	 */
	public function findAllPublished($page, $nbDanceSchoolByPage) {
		$qb = $this->createQueryBuilder('s');
	
		// 		$qb->leftJoin('e.dates', 'd')
		// 		->leftJoin('e.soirees', 'sr')
		// 		->leftJoin('e.stages', 'st')
		// 		->where($qb->expr()->andX(
		// 				$qb->expr()->eq('o.publication', '?1'),
		// 				$qb->expr()->orX(
		// 						$qb->expr()->between('d.dateDebut', '?2', '?3'),
		// 						$qb->expr()->gte('d.dateFin', '?4')
		// 				)
		// 		))
		// 		->orderBy('d.dateDebut', 'ASC')
		// 		->setParameter(1, true)
		// 		->setParameter(2, $startDate)
		// 		->setParameter(3, $endDate)
		// 		->setParameter(4, $now)
		// 		;
	
		// Query building
		$query = $qb->getQuery();
	
		$query->setFirstResult(($page-1) * $nbDanceSchoolByPage)
			  ->setMaxResults($nbDanceSchoolByPage);
	
		return new Paginator($query);
	}
}
