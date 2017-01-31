<?php
namespace Lmi\EventBundle\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Lmi\EventBundle\Constants\Constants;
use Lmi\EventBundle\Constants\ConstServices;
use Lmi\EventBundle\Constants\ConstViews;
use Lmi\EventBundle\Constants\ConstParamAttributs;
 
abstract class AbstractController extends Controller
{  
	/** deletion url attribute name. */
	const ATTRIBUTE_SUPPRESSION_URL = 'suppressionUrl';
	
	/** update URL attribute name. */
	const ATTRIBUTE_UPDATE_URL = 'modificationUrl';
	
	/** entity attribute name. */
	const ATTRIBUTE_ENTITY = 'bean';
	
	/** detail attribute name. */
	const ATTRIBUTE_DETAIL = 'detail';
	
	/** empty message attribute name. */
	const ATTIBUTE_EMPTY_MESSAGE = 'emptyMessage';
	
	/** Nb pages attribute name. */
	const ATTRIBUTE_NB_PAGES = 'nombrePage';
	
	/** list of non published entities Title attribute name. */
	const ATTRIBUTE_LIST_TITLE = 'listeTitle';
	
	/** subtab attribute name. */
	const ATTRIBUTE_SUB_TAB = 'subtab';
	
	/** id attribute name. */
	const ATTRIBUTE_ID = 'id';
	
	/** event id attribute name. */
	const ATTRIBUTE_EVENT_ID = 'eventId';
	
	/** name attribute name. */
	const ATTRIBUTE_NAME = 'name';
	
	/** current page of published entities in listing view . */
	const ATTRIBUTE_PUBLISHED_CURRENT_PAGE = 'pub';
	
	/** current page of non published entities in listing view . */
	const ATTRIBUTE_NON_PUBLISHED_CURRENT_PAGE = 'unPub';
	
	/** form attribute. */
	const ATTRIBUTE_FORM = 'form';
	
	/** form input action. */
	const FORM_INPUT_ACTION = 'action';
	
	/** form input myIds. */
	const FORM_INPUT_MYIDS = 'myIds';
	
	/** Flash Bag info. */
	const FLASH_BAG_INFO = 'info';
	
	/** list of elements attribute name. */
	const ATTRIBUTE_LIST_ELEMENTS = 'listeElements';
	
	/** last update date time. */
	private $dateTimeLastModification = null;
	
	/**
	 * Search action
	 */
	public function rechercherAction($page)
	{
		// check page id
		$this->checkPage($page);
	
		$periodes = null;
		
		// from search form
		if ($this->get(Constants::REQUEST)->getMethod() == Constants::METHOD_POST) {
	
			// 			$searchBean = $this->createSearchForm()[1];
	
// 			$resultSearch = $this->getAdaptedService()->findAllPublished($page, $this->getNbMaxEntitiesByPage());
	
		} else { // from link
			if($this->getRequest()->query->has($this::ATTRIBUTE_EVENT_ID)) {
				$eventId = $this->getRequest()->query->get($this::ATTRIBUTE_EVENT_ID);
				$periodes = $this->getAdaptedService()->findDatesFromEvent($eventId, Constants::DEFAULT_SEARCH_DATES_LIMIT);
			} else {
				$periodes = $this->getAdaptedService()->findDates(Constants::DEFAULT_SEARCH_DATES_LIMIT);
			}
		}
		
		// search date in string
		$searchDateInStr = $this->getSearchDate($periodes);
		
		// Complete parameters list for the renderer view
		$parameters = $this->completeViewParameters($searchDateInStr, $page, $periodes);
	
		return $this->render(ConstViews::VIEW_RESULT_SEARCH, $parameters);
	}
	
	/**
	 * Index
	 */
	public function formulaireAction()
	{
		return $this->render(
				$this->getSearchFormView(),
				array(
						$this::ATTRIBUTE_FORM   => $this->createSearchForm()->createView()
				)
		);
	}
	
	/**
	 * Find the search date.
	 * @param unknown $dates
	 * @return Ambigous <NULL, mixed>
	 */
	protected function getSearchDate($dates)
	{
		// search date in string
		$searchDateInStr = null;
	
		if($this->getRequest()->query->has('date')) {
			$searchDateInStr = $this->getRequest()->query->get('date');
		} else {
			if(count($dates) !== 0) {
				$searchDateInStr = $dates[0]->getDate();
			}
		}
		return $searchDateInStr;
	}
	
	/**
	 * Complete parameters list for the renderer view
	 * @param unknown $searchDateInStr
	 * @param unknown $page
	 * @param unknown $parameters
	 */
	protected  function completeViewParameters($searchDateInStr, $page, $dates)
	{
		// will contain view parameters
		$parameters = array(
				ConstParamAttributs::ATTR_TARGET_VIEW => $this->getRowView(),
				ConstParamAttributs::ATTR_PAGE        => $page,
				ConstParamAttributs::ATTR_TITLE       => $this->get(ConstServices::SERVICE_TRANSLATOR)->trans('question.who.i.am'),
				ConstParamAttributs::ATTR_TAB_DATES   => $dates,
				ConstParamAttributs::ATTR_TYPE_DATA   => $this->getDataType()
		);
		
		if($searchDateInStr !== null) { // date found
			// Build criteria
			$criteria = $this->createCriteria($searchDateInStr, $page);
			
			// find all event for the specified date
			$entities = $this->findEntitiesBy($criteria);
			
			$parameters[ConstParamAttributs::ATTR_TAB_TO_ACTIVATE] = $searchDateInStr;
			$parameters[$this::ATTRIBUTE_LIST_ELEMENTS] = $entities;
			$parameters[$this::ATTRIBUTE_NB_PAGES] = $this->calculateNbPages($entities);
			$parameters[ConstParamAttributs::ATTR_TODAY] = date(Constants::DEFAULT_DATE_FORMAT);
			$parameters[ConstParamAttributs::ATTR_TOMORROW] = (new \DateTime())->add(new \DateInterval('P1D'))->format(Constants::DEFAULT_DATE_FORMAT);
			
			// cases carpooling or accommodation
			if(count($entities) !== 0 && ($this->getDataType() !== 'event')) {
				$parameters['routeSearch'] = $this->getRouteSearch();
			}
		}
		return $parameters;
	}
	
	/**
	 * Calculate the number of pages to generate from a list of elements
	 * @param unknown $listeElements
	 * @return the number of pages to generate
	 */
	protected function calculateNbPages($listeElements) {
		return max(ceil(count($listeElements)/$this->getNbMaxEntitiesByPage()), 1);
	}
	
	/**
	 * Get number of entity to print by page.
	 */
	protected function getNbMaxEntitiesByPage() {
		return Constants::DEFAULT_NB_MAX_ENTITIES_BY_PAGE;
	}
	
	/** 
	 * Build search criteria. 
	 */
	protected function createCriteria($date, $page)
	{
		return array('date' => $date, 'page' => $page);
	}
	
	/** 
	 * Find entities to print. 
	 */
	protected function findEntitiesBy($criteria)
	{
		$date = $criteria['date'];
		$page = $criteria['page'];
		
		if($this->getRequest()->query->has($this::ATTRIBUTE_EVENT_ID)) {
			$eventId = $this->getRequest()->query->get($this::ATTRIBUTE_EVENT_ID);
			return $this->getAdaptedService()->findFromEventAndDate($eventId, $date, $page, $this->getNbMaxEntitiesByPage());
		}
		
		return $this->getAdaptedService()->findFromDate($date, $page, $this->getNbMaxEntitiesByPage());
	}
	
	/**
	 * Get row view.
	 */
	protected abstract function getRowView();
	
	/**
	 * Get data tye.
	 */
	protected abstract function getDataType();
	
	/**
	 * Get the search route
	 */
	protected abstract function getRouteSearch();
	
	/**
	 * Get the adapted service to use.
	 */
	protected abstract function getAdaptedService();
	
	/**
	 * Get page title according to the action.
	 */
	protected abstract function getTitle($action);
	
	/**
	 * Get the message to print when no result according to the action.
	 */
	protected abstract function getNoResultMessage($action);
	
	/**
	 * Get form view
	 */
	protected abstract function getSearchFormView();
	
	/**
	 * Creates a new Form Type.
	 */
	protected abstract function createNewSearchFormType();
	
	/**
	 * Fills the form with request informations
	 * @param searchForm
	 */
	protected function bindRequest($searchForm) {
		$request = $this->get(Constants::REQUEST);
	
		if ($request->getMethod() == Constants::METHOD_POST) {
			$searchForm->bind($request);
	
			if ($searchForm->isValid()) {
				// TODO : do search
				// ....
					
			}
		}
	}
	
	/**
	 * create search form view.
	 */
	protected function createSearchForm() {
		$searchBeanType =  $this->createNewSearchFormType();
		$searchForm = $this->createForm($searchBeanType);
	
		// Fill the form with request informations
		$this->bindRequest($searchForm);
	
		return $searchForm;
	}
	
	/**
	 * Check if the page number is valid.
	 * @param unknown $page
	 * @throws \InvalidArgumentException
	 */
	protected function checkPage($page)
	{
		if ($page < 1) {
			throw new \InvalidArgumentException('L\'argument $page ne peut �tre inf�rieur � 1 (valeur : "'.$page.'").');
		}
	}
	
}
?>
