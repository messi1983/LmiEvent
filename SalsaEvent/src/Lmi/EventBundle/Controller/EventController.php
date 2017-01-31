<?php
namespace Lmi\EventBundle\Controller;
 
use JMS\SecurityExtraBundle\Annotation\Secure;
use Lmi\CoreBundle\Constants\Constants;
use Lmi\CoreBundle\Entity\Event;
use Lmi\EventBundle\Form\SearchEventType;
use Lmi\CoreBundle\Outils\DateOutils;
use Lmi\CoreBundle\Constants\ConstViews;
use Lmi\CoreBundle\Constants\ConstServices;
use Lmi\CoreBundle\Controller\AbstractController;
use Lmi\CoreBundle\Constants\ConstClasses;
use Lmi\CoreBundle\Constants\ConstParamAttributs;
 
class EventController extends AbstractController
{
	/** Year format. */
	const YEAR_FORMAT = 'Y';
	
	/** Nb events started. */
	const NB_EVENTS_STARTED = 'nbStartedEvent';
	
	/**
	 * Index
	 */
	public function indexAction($page)
	{
		// check page id
		$this->checkPage($page);
		
		// default research
		$dates = $this->getAdaptedService()->findDates(Constants::DEFAULT_SEARCH_DATES_LIMIT);
		
		// search date in string
		$searchDateInStr = $this->getSearchDate($dates);
		
		// Complete parameters list for the renderer view
		$parameters = $this->completeViewParameters($searchDateInStr, $page, $dates);
		
		return $this->render(ConstViews::VIEW_HOME, $parameters);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Lmi\EventBundle\Controller\AbstractController::completeViewParameters()
	 */
	protected  function completeViewParameters(&$viewParameters, $searchDateInStr, $page, $eventId)
	{
		// will contain view parameters
		parent::completeViewParameters($viewParameters, $searchDateInStr, $page, $eventId);
		
		if(array_key_exists(ConstParamAttributs::ATTRIBUTE_LIST_ELEMENTS, $viewParameters)) {
			$viewParameters[$this::NB_EVENTS_STARTED] = $this->container->get(ConstServices::SERVICE_EVENT)
															            ->countStartedEvents($viewParameters[ConstParamAttributs::ATTRIBUTE_LIST_ELEMENTS]);
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Lmi\EventBundle\Controller\AbstractController::findEntitiesBy()
	 */
	protected function findEntitiesBy($criteria)
	{
		$date = $criteria['date'];
		$page = $criteria['page'];
		
		return $this->getAdaptedService()->findFromDate($date, $page, $this->getNbMaxEntitiesByPage());
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Lmi\CoreBundle\Controller\AbstractController::getClass()
	 */
	protected function getManagedClass()
	{
		return ConstClasses::CLASS_EVENT;
	}
	
}
?>
