<?php
namespace Lmi\EventBundle\Services;
use Doctrine\ORM\EntityManager;
use Lmi\EventBundle\Entity\Date;
use Doctrine\ORM\Query\ResultSetMapping;
use Lmi\EventBundle\Outils\DateOutils;
use Lmi\EventBundle\Constants\ConstParamAttributs;

/**
 * Abstract service class
 */
abstract class  AbstractPropositionService extends AbstractService
{
	/**
	 * Find entities from an event and date
	 * @param unknown $page
	 * @param unknown $nbElementByPage
	 * @param unknown $eventId
	 */
	public function findFromEventAndDate($eventId, $date, $page, $nbElementByPage)
	{
		return $this->getLinkedRepository()->findFromEventAndDate($eventId, $date, $page, $nbElementByPage);
	}
	
	/**
	 * Find next published carpooling dates
	 * @param integer $eventId
	 */
	public function findDatesFromEvent($eventId, $limit) {
		$queryName = $this->getQueryName(2);
		$parametres = array(ConstParamAttributs::PARAM_SQL_PUBLISHED => true, 
				            ConstParamAttributs::PARAM_SQL_LIMIT => $limit, 
				            ConstParamAttributs::PARAM_SQL_EVENT_ID => $eventId);
		
		return DateOutils::replaceOldDatesByCurrentDate($this->dateRepository->executeQuery($queryName, $parametres));
	}
	
	/**
	 * Find entities from a date
	 * @param unknown $page
	 * @param unknown $nbAccByPage
	 */
	public function findFromDate($date, $page, $nbAccByPage) {
		return  $this->getLinkedRepository()->findFromDate($date, $page, $nbAccByPage);
	}
	
}
?>
