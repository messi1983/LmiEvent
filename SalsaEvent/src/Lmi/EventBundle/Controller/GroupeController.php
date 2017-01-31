<?php
namespace Lmi\EventBundle\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Lmi\EventBundle\Entity\User;
use Lmi\EventBundle\Form\UserType;
use Lmi\EventBundle\Form\AuthType;
use Lmi\EventBundle\Form\UserProfilType;
use Lmi\EventBundle\Entity\GroupeContacts;
use Lmi\EventBundle\Form\GroupeType;
use Lmi\EventBundle\Constants\ConstViews;
 
class GroupeController extends Controller
{ 
	/** form attribute. */
	const ATTRIBUTE_FORM = 'form';
	
	/** header referer. */
	const HEADER_REFERER = 'referer';
	
	/**
	 * create a new group action
	 */
	public function creerAction()
	{
		$groupe =  new GroupeContacts();
		
		$contacts = array();
		
		for ($i=0; $i<10; $i++) {
	    	$member =  new User();
			$member->setLastname("Messi".$i);
			$member->setFirstname("Louis".$i);
			$member->setSexe("M");
			$contacts[] = $member;
		}
		
		$groupeForm = $this->createForm(new GroupeType(), $groupe);
	
		return $this->render(
				ConstViews::VIEW_FORM_NEW_GROUP,
				array(
						$this::ATTRIBUTE_FORM => $groupeForm->createView(),
						'contacts'            => $contacts
				)
		);
	}
	
}
?>
