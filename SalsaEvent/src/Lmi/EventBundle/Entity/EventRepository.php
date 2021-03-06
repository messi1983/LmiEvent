<?php

namespace Lmi\EventBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Lmi\EventBundle\Constants\ConstParamAttributs;
use Lmi\EventBundle\Outils\DateOutils;

/**
 * SoireeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventRepository extends AbstractRepository
{
	/**
	 * Get next published events between startDate and endDate
	 * @param \DateTime $startDate
	 * @param \DateTime $endDate
	 */
	public function findFromDate($dateInStr, $page, $nbEventByPage) {
		$qb = $this->createQueryBuilder('e');
	
		$qb->leftJoin('e.soirees', 'sr')
		   ->leftJoin('e.stages', 'st')
		   ->leftJoin('sr.dates', 'dsr')
		   ->leftJoin('st.dates', 'dst')
		   ->where($qb->expr()->andX(
			      $qb->expr()->eq('e.publication', ':published'),
				  $qb->expr()->orX(
					  $qb->expr()->eq("DATE_FORMAT(dst.dateDebut, '%Y-%m-%d')", ':dateDebut'),
		  			  $qb->expr()->eq("DATE_FORMAT(dsr.dateDebut, '%Y-%m-%d')", ':dateDebut')
				   )
			   )
		    )
		->setParameter(ConstParamAttributs::PARAM_SQL_PUBLISHED, true)
		->setParameter(':dateDebut', $dateInStr);
		
		return $this->buildPaginator($qb->getQuery(), $page, $nbEventByPage);
	}
	
	/**
	 * Get published events starting at the current day
	 */
	public function findFromCurrentDay($page, $nbEventByPage) {
		$dateDebutMax = DateOutils::createMaxDateTime(new \DateTime());
		$qb = $this->createQueryBuilder('e');
	
		$qb->leftJoin('e.soirees', 'sr')
		->leftJoin('e.stages', 'st')
		->leftJoin('sr.dates', 'dsr')
		->leftJoin('st.dates', 'dst')
		->where($qb->expr()->andX(
				$qb->expr()->eq('e.publication', ':published'),
				$qb->expr()->orX(
						$qb->expr()->andX(
								$qb->expr()->gte('dst.dateFin', ':currentDateTime'),
								$qb->expr()->lte("dst.dateDebut", ':dateDebutMax')
						),
						$qb->expr()->andX(
								$qb->expr()->gte('dsr.dateFin', ':currentDateTime'),
								$qb->expr()->lte("dsr.dateDebut", ':dateDebutMax')
						)
				)
		)
		)
		->setParameter(ConstParamAttributs::PARAM_SQL_PUBLISHED, true)
		->setParameter('currentDateTime', new \DateTime())
		->setParameter('dateDebutMax', $dateDebutMax);
	
		return $this->buildPaginator($qb->getQuery(), $page, $nbEventByPage);
	}
}
