<?php
namespace Lmi\EventBundle\Controller;
 
use Lmi\EventBundle\Form\EventType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Lmi\EventBundle\Constants\Constants;
use Lmi\EventBundle\Form\SearchDanceSchoolType;
use Lmi\EventBundle\Constants\ConstViews;
use Lmi\EventBundle\Constants\ConstServices;
 
class DanceSchoolController extends AbstractController
{	
	/**
	 * Search action
	 */
	public function rechercherAction($page)
	{
		// check page id
		$this->checkPage($page);
	
		$schools = null;
	
		// from search form
		if ($this->get(Constants::REQUEST)->getMethod() == Constants::METHOD_POST) {
	
		} else { // from link
			$schoolId = $this->getRequest()->query->get('schoolId');
				
			if($schoolId === null) {
				// Find all per
				$schools = $this->getAdaptedService()->findAllDanceSchools($page, $this->getNbMaxEntitiesByPage());
			}
		}
	
		// Complete parameters list for the renderer view
		$parameters = $this->completeViewParameters(null, $page, null);
		$parameters[$this::ATTRIBUTE_LIST_ELEMENTS] = $schools;
		$parameters[$this::ATTRIBUTE_NB_PAGES] = $this->calculateNbPages($schools);
	
		return $this->render(ConstViews::VIEW_RESULT_SEARCH, $parameters);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Lmi\EventBundle\Controller\AbstractController::getRowView()
	 */
	protected function getRowView()
	{
		return ConstViews::VIEW_ROW_DANCE_SCHOOL;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Lmi\EventBundle\Controller\AbstractController::getRouteSearch()
	 */
	protected function getRouteSearch()
	{
		return 'lmievent_rechercher_ecoles';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Lmi\EventBundle\Controller\AbstractController::getAdaptedService()
	 */
	protected function getAdaptedService() {
		return $this->container->get(ConstServices::SERVICE_DANCE_SCHOOL);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Lmi\EventBundle\Controller\AbstractController::getSearchFormView()
	 */
	protected function getSearchFormView() {
		return ConstViews::VIEW_FORM_SEARCH_SCHOOLDANCE;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Lmi\EventBundle\Controller\AbstractController::getTitle()
	 */
	protected function getTitle($action)
	{
		if($action == Constants::ACTION_DETAIL) {
			return $this->get(ConstServices::SERVICE_TRANSLATOR)->trans('ecole.detail');
		}
		else if ($action == Constants::ACTION_ADD) {
			return $this->get(ConstServices::SERVICE_TRANSLATOR)->trans('ecole.add');
		}
		else if ($action == Constants::ACTION_DELETE) {
			return $this->get(ConstServices::SERVICE_TRANSLATOR)->trans('ecole.deletion');
		}
		else if ($action == Constants::ACTION_UPDATE) {
			return $this->get(ConstServices::SERVICE_TRANSLATOR)->trans('ecole.modification');
		}
		
		return $this->get(ConstServices::SERVICE_TRANSLATOR)->trans('ecole.liste.label');
	}
	
	protected function getNotPublishedListTitle()
	{
		return $this->get(ConstServices::SERVICE_TRANSLATOR)->trans('ecole.liste.not.published.label');
	}
	
	protected function getPublishedListTitle()
	{
		return $this->get(ConstServices::SERVICE_TRANSLATOR)->trans('ecole.liste.published.label');
	}
	
	protected function getBackUpDetailMessage()
	{
		return $this->get(ConstServices::SERVICE_TRANSLATOR)->trans('ecole.goback');
	}
	
	protected function getNoResultMessage($action)
	{
		return $this->get(ConstServices::SERVICE_TRANSLATOR)->trans('ecole.empty');
	}
	
	protected function getDeletionConfirmationMessage()
	{
		return $this->get(ConstServices::SERVICE_TRANSLATOR)->trans('ecole.delete.confirmation.message');
	}
	
	protected function getFlashBagMessage($action)
	{
		if($action == Constants::ACTION_DELETE) {
			return $this->get(ConstServices::SERVICE_TRANSLATOR)->trans('ecole.delete.flash.message');
		}
		return $this->get(ConstServices::SERVICE_TRANSLATOR)->trans('ecole.update.flash.message');
	}
	
	protected function getDetailView()
	{
		return Constants::ECOLE_VIEW;
	}
   
	protected function getClass()
	{
		return Constants::CLASS_EVENT;
	}
   
	protected function getListingUrl()
	{
		return Constants::ROUTE_VOIR_ECOLES;
	}
	protected function getNbMaxEntitiesByPage()
	{
		return 6/*Constants::DEFAULT_NB_MAX_ENTITIES_BY_PAGE*/;
	}
   
	protected function getDeletionUrl()
	{
		return Constants::ROUTE_SUPPRIMER_ECOLE;
	}
   
    protected function getModificationUrl()
	{
		return Constants::ROUTE_MODIFIER_ECOLE;
	}
	
	protected function getDetailUrl()
	{
		return Constants::ROUTE_VOIR_ECOLE;
	}
	
	/**
	 * Create a form type
	 */
	protected function createNewSearchFormType()
	{
		return new SearchDanceSchoolType;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Lmi\EventBundle\Controller\AbstractController::getDataType()
	 */
	protected function getDataType()
	{
		return 'danceschool';
	}
}
?>
