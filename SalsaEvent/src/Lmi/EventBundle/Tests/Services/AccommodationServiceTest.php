<?php

use Lmi\EventBundle\Services\EventService;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Lmi\EventBundle\Entity\Event;
use Lmi\EventBundle\Entity\Soiree;
use Lmi\EventBundle\Entity\Stage;
use Lmi\EventBundle\Entity\Periode;
use Lmi\EventBundle\Constants\Constants;
use Lmi\EventBundle\Entity\Accommodation;
use Lmi\EventBundle\Entity\User;
use Lmi\EventBundle\Entity\Adresse;
use Lmi\EventBundle\Services\AccommodationService;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

/**
 * AccommodationService test class
 * @author Messi
 *
 */
class AccommodationServiceTest extends AbstractServiceTest
{
	/**
	 * @var Lmi\EventBundle\Services\AccommodationService
	 */
	private  static $accommodationService;
	
	private static $event_heb_LP_auj;
	
	/**
	 * {@inheritDoc}
	 */
	public static function setUpBeforeClass() {
	
		parent::setUpBeforeClass();
        
        static::$accommodationService = new AccommodationService(static::$em);
        
        static::loadData();
	}
	
	/**
	 * findDates() method test
	 */
    public function testFindDates()
    {
    	$result = static::$accommodationService->findDates(7);
    	
    	//
    	// Result checking
    	//
    	$auj = (new \DateTime())->format(Constants::DEFAULT_DATE_FORMAT);
    	$demain = (new \DateTime())->add(new \DateInterval('P1D'))->format(Constants::DEFAULT_DATE_FORMAT);
    	$dans10j = (new \DateTime())->add(new \DateInterval('P10D'))->format(Constants::DEFAULT_DATE_FORMAT);
    	
    	$this->assertNotNull($result);
    	$this->assertCount(3, $result);
    	$this->assertEquals($auj, $result[0]->getDate());
    	$this->assertEquals($demain, $result[1]->getDate());
    	$this->assertEquals($dans10j, $result[2]->getDate());
    }
    
    /**
     * findDatesFromEvent() method test
     */
    public function testFindDatesFromEvent()
    {
    	$result = static::$accommodationService->findDatesFromEvent(static::$event_heb_LP_auj->getId(), 7);
    	 
    	//
    	//
    	$auj = (new \DateTime())->format(Constants::DEFAULT_DATE_FORMAT);
    	$dans10j = (new \DateTime())->add(new \DateInterval('P10D'))->format(Constants::DEFAULT_DATE_FORMAT);
    	 
    	$this->assertNotNull($result);
    	$this->assertCount(2, $result);
    	$this->assertEquals($auj, $result[0]->getDate());
    	$this->assertEquals($dans10j, $result[1]->getDate());
    }
    
    /**
     * BDD Initialisation
     */
    private static function loadData()
    {
    	// periodes
    	$p10_au_11_mai_2015 = static::createPastPeriode('2015-05-10', '2015-05-11');
    	$pHier_Auj_Fini_Dans2h = static::createCurrentPeriode('P1D', 'PT2H');
    	$pAuj = static::createFuturPeriode('PT1H', 'PT3H');
    	$pDemain_ApresDemain = static::createFuturPeriode('P1D', 'P2D');
    	$pDans_10_jours = static::createFuturPeriode('P10D', 'P10DT1H');
    	
    	//
    	// Users
    	//
    	$userMessi = static::createUser('Mario', 'mario.louis@yahoo.fr', 'merde');
    	$userManu = static::createUser('Manu', 'manu.louis@yahoo.fr', 'ok');
    	$userChaput = static::createUser('Chaput', 'chaput.louis@yahoo.fr', 'bruns');
    	$userLP = static::createUser('LE PIOUF', 'lpiouf.louis@yahoo.fr', 'bens');
    
    	//
    	// Adresses
    	//
    	$ad_Tlse_Pech_Dav = static::createAdresse(08, 'Chemin des cotes de Pech David', 31400, 'Toulouse');
    	$ad_Monpipi = static::createAdresse(097, 'rue de la Fayette', 34400, 'Montpellier');
    	 
    	//
    	// Hebergements
    	//
    	$heb_LP_an_dernier = static::createAccommodation('C', $p10_au_11_mai_2015, $ad_Tlse_Pech_Dav, $userLP, [$userChaput, $userMessi]);
    	$heb_LP_fini_dans_2h = static::createAccommodation('C', $pHier_Auj_Fini_Dans2h, $ad_Tlse_Pech_Dav, $userLP, [$userChaput, $userMessi]);
    	$heb_Messi_auj = static::createAccommodation('H', $pAuj, $ad_Monpipi, $userMessi, [$userManu, $userLP]);
    	$heb_Chaput_dans_10_jours = static::createAccommodation('H', $pDans_10_jours, $ad_Monpipi, $userChaput, [$userManu, $userLP]);
    	$heb_Chaput_demain_a_apresDemain = static::createAccommodation('H', $pDemain_ApresDemain, $ad_Monpipi, $userChaput, [$userManu, $userLP]);
    
    	// events
    	$event_heb_LP_an_dernier = static::createEventFromAcc('event pour hebergement an dernier', [$heb_LP_an_dernier]);
    	static::$event_heb_LP_auj = static::createEventFromAcc('event pour hebergement pour aujourdhui', [$heb_LP_fini_dans_2h, $heb_Chaput_dans_10_jours]);
    	$event_heb_Messi_auj = static::createEventFromAcc('event pour hebergement pour aujourdhui bis', [$heb_Messi_auj]);
    	$event_heb_Chaput_demain_a_apresDemain  = static::createEventFromAcc('event pour heb demain a apres demain', [$heb_Chaput_demain_a_apresDemain]);
    
    	static::persist([$event_heb_LP_an_dernier, static::$event_heb_LP_auj, $event_heb_Messi_auj, $event_heb_Chaput_demain_a_apresDemain]);
    }
    
}
?>