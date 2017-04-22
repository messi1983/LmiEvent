<?php
namespace Lmi\CoreBundle\Services;

use Doctrine\ORM\EntityManager;
use Lmi\CoreBundle\Constants\ConstParamAttributs;
use Lmi\CoreBundle\Entity\Date;
use Doctrine\ORM\Query\ResultSetMapping;
use Lmi\CoreBundle\Outils\DateOutils;
use Lmi\CoreBundle\Twig\AppExtension;
use Lmi\CoreBundle\Constants\ConstClasses;
use Lmi\CoreBundle\Services\AbstractService;

/**
 * Event service class
 */
class EventService extends AbstractService
{
	/** 
	 * utilitarian class for twig. 
	 */
	protected $appExtension;
	
	/**
	 * Constructor
	 */
	public function __construct(EntityManager $em, AppExtension $appExtension)
	{
		parent::__construct($em);
		$this->appExtension = $appExtension;
	}
	
	/**
	 * Find next events dates between dateDebut and dateFin
	 * @param unknown $dateMin
	 * @param unknown $dateMax
	 */
	public function findDatesBetween($dateMin, $dateMax) 
	{
		$parametres = array(ConstParamAttributs::PARAM_SQL_PUBLISHED => true, 'dateTimeMax' => DateOutils::createMaxDateTime($dateMax));
		$queryName = null;
		$finalResult = null;
		
		if($dateMin <= new \DateTime()) { // si dateMin = today
			$queryName = $this->getQueryName(2);
			$finalResult = DateOutils::replaceOldDatesByCurrentDate($this->dateRepository->executeQuery($queryName, $parametres));
		} else {
			$queryName = $this->getQueryName(3);
			$parametres['dateTimeMin'] = DateOutils::createMinDateTime($dateMin);
			$finalResult = $this->dateRepository->executeQuery($queryName, $parametres);
		}
		
		return $finalResult;
	}
	
	/**
	 * Count the number of started events in the input list
	 * @param unknown $events
	 * @return multitype:unknown
	 */
	public function countStartedEvents($events) {
		$now = new \DateTime();
		$counter = 0;
	
		foreach ($events as $event) {
			$periode = $this->appExtension->periodeFilter($event, 'soiree');
			
			if($periode->getDateDebut() < $now) {
				$counter++;
			}
		}
		return $counter;
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
				$queryName = 'eventsDates_1';
				break;
				
			case 2;
				$queryName = 'eventsDates_2';
				break;
				
			default:
				$queryName = 'eventsDates_3';
		}
		return $queryName;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Lmi\EventBundle\Services\AbstractService::getLinkedRepository()
	 */
	protected function getLinkedRepository()
	{
		return $this->em->getRepository(ConstClasses::CLASS_EVENT);
	}
	
	/**
	 //       * update event dates after stage or soiree addition
	 //       * @param dates of added stage or soiree
	 //       */
	//      private function updateDatesAfterStageOrSoireeAddition(\Lmi\EventBundle\Entity\Periode $dates)
	//      {
	// 	     if($this->dates === null) {
	// 	     	$this->dates = new Periode();
	// 	     }
	 
	// 	     if($this->getDateDebut() === null) {
	// 	     	$this->dates->setDateDebut($dates->getDateDebut());
	// 	     } else if(var_dump($this->getDateDebut() > $dates->getDateDebut())) {
	// 	     	$this->dates->setDateDebut($dates->getDateDebut());
	// 	     }
	 
	// 	     if($this->getDateFin() === null) {
	// 	     	$this->dates->setDateFin($dates->getDateFin());
	// 	     } else if(var_dump($this->getDateFin() < $dates->getDateFin())) {
	// 	     	$this->dates->setDateFin($dates->getDateDebut());
	// 	     }
	//      }
	 
	//      /**
	//       * update event dates after stage or soiree deletion
	//       * @param dates of deleted stage or soiree
	//       */
	//      private function updateDatesAfterStageOrSoireeDeletion(\Lmi\EventBundle\Entity\Periode $dates)
	//      {
	//      	if($dates !== null) {
	//      		if(var_dump($this->getDateDebut() == $dates->getDateDebut())) {
	//      			$minDateDebutStage = $this->getMinDateDebut($this->stages);
	//      			$minDateDebutSoiree = $this->getMinDateDebut($this->soirees);
	
	//      			if(var_dump($minDateDebutStage < $minDateDebutSoiree)) {
	//      				$this->dates->setDateDebut($minDateDebutStage);
	//      			} else {
	//      				$this->dates->setDateDebut($minDateDebutSoiree);
	//      			}
	//      		}
	 
	//      		if(var_dump($this->getDateFin() == $dates->getDateFin())) {
	//      			$maxDateFinStage = $this->getMinDateFin($this->stages);
	//      			$maxDateFinSoiree = $this->getMinDateFin($this->soirees);
	
	//      			if(var_dump($maxDateFinStage > $maxDateFinSoiree)) {
	//      				$this->dates->setDateFin($maxDateFinStage);
	//      			} else {
	//      				$this->dates->setDateFin($maxDateFinSoiree);
	//      			}
	//      		}
	//      	}
	//      }
	 
	//      /**
	//       * Get min date in a list of stages or soirees
	//       * @param dates
	//       */
	//      private function getMinDateDebut($list)
	//      {
	//      	$dateDebutMin = null;
	//      	if($list !== null) {
	//      		foreach($list as $s) {
	//      			if(var_dump($dateDebutMin > $s->getDateDebut())) {
	//      				$dateDebutMin = $s->getDateDebut();
	//      			}
	//      		}
	//      	}
	//      	return $dateDebutMin;
	//      }
	 
	//      /**
	//       * Get max date in a list of stages or soirees
	//       * @param dates
	//       */
	//      private function getMaxDateFin($list)
	//      {
	//      	$dateFinMax = null;
	//      	if($list !== null) {
	//      		foreach($list as $s) {
	//      			if(var_dump($dateFinMax < $s->getDateFin())) {
	//      				$dateFinMax = $s->getDateFin();
	//      			}
	//      		}
	//      	}
	//      	return $dateFinMax;
	//      }
	
}
?>
