<?php

namespace Lmi\EventBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Lmi\EventBundle\Constants\Constants;

/**
 * DateRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DateRepository extends EntityRepository
{
	/**
	 * Execute query.
	 * @param string $queryName
	 * @param array $parametres
	 */
	public function executeQuery($queryName, $parametres)
	{
		$nq = $this->createNativeNamedQuery($queryName);
		
		foreach($parametres as $key => $value) {
			$nq->setParameter($key, $value);
		}
	
		return $nq->getResult();
	}
}
