<?php
namespace Lmi\EventBundle\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Lmi\EventBundle\Constants\Constants;
use Lmi\EventBundle\Entity\User;
use Lmi\EventBundle\Form\UserType;
use Lmi\EventBundle\Form\AuthType;
use Lmi\EventBundle\Form\UserProfilType;
use Lmi\EventBundle\Form\BankAccountType;
use Lmi\EventBundle\Form\CarInfosType;
use Lmi\EventBundle\Entity\BankAccount;
use Lmi\EventBundle\Entity\CarInfos;
use Lmi\EventBundle\Constants\ConstViews;
use Lmi\EventBundle\Constants\ConstServices;
use Lmi\EventBundle\Constants\ConstParamAttributs;
 
class UserController extends Controller
{ 
	/** form attribute. */
	const ATTRIBUTE_FORM = 'form';
	
	/** form profil attribute. */
	const ATTRIBUTE_FORM_PROFIL = 'formProfil';
	
	/** form bank account attribute. */
	const ATTRIBUTE_FORM_BANK_ACCOUNT = 'formBankAccount';
	
	/** form car infos attribute. */
	const ATTRIBUTE_FORM_CAR_INFOS = 'formCarInfos';
	
	/** POST method. */
	const METHOD_POST = 'POST';
	
	/** header referer. */
	const HEADER_REFERER = 'referer';
	
	/**
	 * Identifiers update
	 */
	public function identifiersAction()
	{
		// Manager of last update date
		$this->container->get(Constants::ADMIN_USER_MANAGER)->updateAdminAuthInfos();
	
		return $this->render(ConstViews::VIEW_NONE);
	}
	
	/**
	 * Inscription action
	 */
	public function inscriptionAction()
	{
		$user =  new User();
		
		$userInscriptionForm = $this->createForm(new UserType(), $user);
		$request = $this->getRequest();
	
		if ($request->getMethod() == $this::METHOD_POST) {
			$userInscriptionForm->bind($request);
				
			if($userInscriptionForm->isValid()) {
				// Save new user
				$this->container->get(ConstServices::SERVICE_USER_MANAGER)->saveOrUpdate($user);
	
				$referer = $this->getRequest()->headers->get($this::HEADER_REFERER);
	
				return $this->redirect($referer);
			}
		}
	
		return $this->render(
				ConstViews::VIEW_FORM_INSCRIPTION,
				array(
						$this::ATTRIBUTE_FORM => $userInscriptionForm->createView()
				)
		);
	}
	
	/**
	 * Authentification action
	 */
	public function authentificationAction()
	{
		$authForm = $this->createForm(new AuthType());
		$request = $this->getRequest();
	
		if ($request->getMethod() == $this::METHOD_POST) {
			$authForm->bind($request);
				
			if($authForm->isValid()) {
				// TODO
			}
		}
	
		return $this->render(
				ConstViews::VIEW_FORM_AUTH,
				array(
					$this::ATTRIBUTE_FORM => $authForm->createView()
				)
		);
	}
	
	/**
	 * dashbord action
	 * @param User $user
	 */
	public function dashboardAction(User $user = null)
	{
		$username = 'Mario';//$this->get(Constants::SECURITY_CONTEXT)->getToken()->getUser();
		
		$user = $this->container->get(ConstServices::SERVICE_USER_MANAGER)->findByLogin($username);
		
		$userBankAccount = $user->getBankAccount();
		
		if($userBankAccount === null) {
			$userBankAccount = new BankAccount();
			$userBankAccount->setHolder("Messi Louis");
		}
		
		$userCarInfos = new CarInfos();
		$userCarInfos->setDesignation("Renault Megane 3");
		$userCarInfos->setNbPlaces(4);
		
		// User profil form creation
		$userProfilForm = $this->createForm(new UserProfilType(), $user);
		
		// User bank account form creation
		$userBankAccountForm = $this->createForm(new BankAccountType(), $userBankAccount);
		
		// User bank account form creation
		$userCarInfosForm = $this->createForm(new CarInfosType(), $userCarInfos);
		
		return $this->render(
				ConstViews::VIEW_USER_DASHBORD,
				array(
						$this::ATTRIBUTE_FORM_PROFIL       => $userProfilForm->createView(),
						$this::ATTRIBUTE_FORM_BANK_ACCOUNT => $userBankAccountForm->createView(),
						$this::ATTRIBUTE_FORM_CAR_INFOS    => $userCarInfosForm->createView(),
						'user'                             => $user,
						ConstParamAttributs::ATTR_TYPE_DATA => 'all'
				)
		);
	}
	
}
?>
