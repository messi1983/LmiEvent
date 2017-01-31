<?php
namespace Lmi\EventBundle\Controller;
 
use Lmi\EventBundle\Form\EventType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Lmi\EventBundle\Constants\Constants;
use Lmi\EventBundle\Form\SearchStoreType;
use Lmi\EventBundle\Constants\ConstServices;
 
class StoreController extends AbstractController
{
	/**
	 * (non-PHPdoc)
	 * @see \Lmi\EventBundle\Controller\AbstractController::findEntitiesBy()
	 */
	protected function findEntitiesBy($criteria)
	{
		$date = $criteria['date'];
		$page = $criteria['page'];
	
		return null;//$this->getAdaptedService()->findEventsPublishedFromDate($date, $page, $this->getNbMaxEntitiesByPage());
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Lmi\EventBundle\Controller\AbstractController::getRowView()
	 */
	protected function getRowView()
	{
		return Constants::ROW_STORE_VIEW;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Lmi\EventBundle\Controller\AbstractController::getRouteSearch()
	 */
	protected function getRouteSearch()
	{
		return 'lmievent_rechercher_commerces';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Lmi\EventBundle\Controller\AbstractController::getAdaptedService()
	 */
	protected function getAdaptedService() {
		return $this->container->get(ConstServices::SERVICE_STORE);
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see \Lmi\EventBundle\Controller\AbstractController::getSearchFormView()
	 */
	protected function getSearchFormView() {
		return 'LmiEventBundle:Form:formSearchStore.html.twig';
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
		return Constants::DEFAULT_NB_MAX_ENTITIES_BY_PAGE;
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
		return new SearchStoreType;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Lmi\EventBundle\Controller\AbstractController::getDataType()
	 */
	protected function getDataType()
	{
		return 'store';
	}
	
}
?>
