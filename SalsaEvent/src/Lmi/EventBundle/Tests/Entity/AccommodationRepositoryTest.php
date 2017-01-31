<?php

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Lmi\CoreBundle\Constants\Constants;
use Lmi\CoreBundle\Entity\Event;
use Lmi\CoreBundle\Entity\Periode;
use Lmi\CoreBundle\Entity\Stage;
use Lmi\CoreBundle\Entity\Soiree;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Lmi\CoreBundle\Entity\CarPooling;
use Lmi\CoreBundle\Entity\User;
use Lmi\CoreBundle\Entity\Trajet;
use Lmi\CoreBundle\Entity\Accommodation;
use Lmi\CoreBundle\Entity\Adresse;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Lmi\CoreBundle\Constants\ConstClasses;
use Lmi\EventBundle\Tests\TestOutils;

/**
 * AccommodationRepository Test class
 * @author Messi
 *
 */
class AccommodationRepositoryTest extends AbstractRepositoryTest
{
	/**
	 * @var Lmi\EventBundle\Entity\AccommodationRepository
	 */
	private static $accommodationRepository;
	
	private static $pHier_Auj_Fini_Dans2h;
	
	private static $pAuj_Demain;
	
	private static $pAuj;
	
	private static $event_heb_LP_auj;
	
	private static $p10_au_11_mai_2015;
	
	private static $p10_au_20_juin_2015;
	
	private static $pDemain_ApresDemain;
	
	private static $pDemain_jPlus3;
	
	private static $pApresDemain_jPlus3;
	
	private static $userMessi;
	
	private static $userManu;
	
	private static $userChaput;
	
	private static $userLP;
	
	private static $ad_Tlse_Pech_Dav;
	
	private static $ad_Monpipi;
	
	/**
	 * {@inheritDoc}
	 */
	public static function setUpBeforeClass() {
	
		parent::setUpBeforeClass();
        
        static::$accommodationRepository = static::$em->getRepository(ConstClasses::CLASS_ACCOMMODATION);
		
        static::loadData();
	}
	
	/**
	 * findFromDate() method test
	 */
    public function testFindFromDate()
    {
    	//
    	// Pre conditions
    	//
    	$heb_Chaput_10_au_20_juin_2015 = TestOutils::createAccommodation('H', static::$p10_au_20_juin_2015, static::$ad_Monpipi, static::$userChaput, [static::$userManu, static::$userLP], static::$event_heb_LP_auj);
    	$heb_Chaput_demain_a_apresDemain = TestOutils::createAccommodation('H', static::$pDemain_ApresDemain, static::$ad_Monpipi, static::$userChaput, [static::$userManu, static::$userLP], static::$event_heb_LP_auj);
    	$heb_LP_demain_jPlus3 = TestOutils::createAccommodation('C', static::$pDemain_jPlus3, static::$ad_Tlse_Pech_Dav, static::$userLP, [static::$userChaput, static::$userMessi], static::$event_heb_LP_auj);
    	$heb_LP_apresDemain_jPlus3 = TestOutils::createAccommodation('C', static::$pApresDemain_jPlus3, static::$ad_Tlse_Pech_Dav, static::$userLP, [static::$userChaput, static::$userMessi], static::$event_heb_LP_auj);
    	
    	static::persist([$heb_Chaput_10_au_20_juin_2015, $heb_Chaput_demain_a_apresDemain, $heb_LP_demain_jPlus3, $heb_LP_apresDemain_jPlus3]);
    	 
    	//
    	//
    	
    	// Execution méthode
        $result = static::$accommodationRepository->findFromDate((new \DateTime())->add(new \DateInterval('P1D')), 1, 3);
        $hebergements = TestOutils::paginatorToArray($result);
        //
        //
        $this->assertNotNull($result);
        $this->assertCount(2, $result);
        
        $this->assertNotNull($hebergements[0]->getHost());
        $this->assertNotNull($hebergements[1]->getHost());
        $this->assertEquals(static::$userChaput, $hebergements[0]->getHost());
        $this->assertEquals(static::$userLP, $hebergements[1]->getHost());
        
        $this->assertCount(1, $hebergements[0]->getEvents());
        $this->assertCount(1, $hebergements[1]->getEvents());
		$this->assertEquals(static::$event_heb_LP_auj, $hebergements[0]->getEvents()[0]);
		$this->assertEquals(static::$event_heb_LP_auj, $hebergements[1]->getEvents()[0]);
		
		$this->assertNotNull($hebergements[0]->getPeriode());
		$this->assertNotNull($hebergements[1]->getPeriode());
    	$this->assertEquals(static::$pDemain_ApresDemain, $hebergements[0]->getPeriode());
    	$this->assertEquals(static::$pDemain_jPlus3, $hebergements[1]->getPeriode());
    }
    
    /**
     * findFromEventAndDate() method test
     */
    public function testFindFromEventAndDate()
    {
    	//
    	// Pre conditions
    	//
    	$heb_LP_fini_dans_2h = TestOutils::createAccommodation('C', static::$pHier_Auj_Fini_Dans2h, static::$ad_Tlse_Pech_Dav, static::$userLP, [static::$userChaput, static::$userMessi], static::$event_heb_LP_auj);
    	$heb_Chaput_auj_a_demain = TestOutils::createAccommodation('H', static::$pAuj_Demain, static::$ad_Monpipi, static::$userChaput, [static::$userManu, static::$userLP], static::$event_heb_LP_auj);
    	$heb_LP_an_dernier = TestOutils::createAccommodation('C', static::$p10_au_11_mai_2015, static::$ad_Tlse_Pech_Dav, static::$userLP, [static::$userChaput, static::$userMessi], static::$event_heb_LP_auj);
    	 
    	static::persist([$heb_LP_fini_dans_2h, $heb_Chaput_auj_a_demain, $heb_LP_an_dernier]);
    	
    	//
    	//
    	
    	// Execution méthode
    	$result = static::$accommodationRepository->findFromEventAndDate(static::$event_heb_LP_auj->getId(), new \DateTime(), 1, 3);
    	$hebergements = TestOutils::paginatorToArray($result);
    	//
    	//
    	
    	$this->assertNotNull($result);
    	$this->assertCount(2, $result);
    	
    	$this->assertNotNull($hebergements[0]->getHost());
        $this->assertNotNull($hebergements[1]->getHost());
        $this->assertEquals(static::$userChaput, $hebergements[0]->getHost());
        $this->assertEquals(static::$userLP, $hebergements[1]->getHost());
        
        $this->assertCount(1, $hebergements[0]->getEvents());
        $this->assertCount(1, $hebergements[1]->getEvents());
        $this->assertEquals(static::$event_heb_LP_auj, $hebergements[0]->getEvents()[0]);
        $this->assertEquals(static::$event_heb_LP_auj, $hebergements[1]->getEvents()[0]);
        
        $this->assertNotNull($hebergements[0]->getPeriode());
        $this->assertNotNull($hebergements[1]->getPeriode());
    	$this->assertEquals(static::$pAuj_Demain, $hebergements[0]->getPeriode());
    	$this->assertEquals(static::$pHier_Auj_Fini_Dans2h, $hebergements[1]->getPeriode());
    }
    
    /**
     * BDD initialisation
     */
    private static function loadData()
    {
    	// periodes
    	static::$p10_au_11_mai_2015 = TestOutils::createPastPeriode('2015-05-10', '2015-05-11');
    	static::$p10_au_20_juin_2015 = TestOutils::createPastPeriode('2015-06-10', '2015-06-20');
    	static::$pHier_Auj_Fini_Dans2h = TestOutils::createCurrentPeriode('P1D', 'PT2H');;
    	static::$pAuj =  TestOutils::createFuturPeriode('PT1H', 'PT3H');
    	static::$pAuj_Demain =  TestOutils::createFuturPeriode('PT2H', 'P1D');
    	static::$pDemain_ApresDemain = TestOutils::createFuturPeriode('P1D', 'P2D');
    	static::$pDemain_jPlus3 = TestOutils::createFuturPeriode('P1D', 'P3D');
    	static::$pApresDemain_jPlus3 = TestOutils::createFuturPeriode('P2D', 'P3D');
    	static::persist([static::$p10_au_11_mai_2015, static::$pHier_Auj_Fini_Dans2h, static::$pAuj, static::$pAuj_Demain, static::$pDemain_ApresDemain, static::$pDemain_jPlus3, static::$pApresDemain_jPlus3]);
    	
    	//
    	// Users
    	//
    	static::$userMessi = TestOutils::createUser('Mario', 'mario.louis@yahoo.fr', 'merde');
    	static::$userManu = TestOutils::createUser('Manu', 'manu.louis@yahoo.fr', 'ok');
    	static::$userChaput = TestOutils::createUser('Chaput', 'chaput.louis@yahoo.fr', 'bruns');
    	static::$userLP = TestOutils::createUser('LE PIOUF', 'lpiouf.louis@yahoo.fr', 'bens');
    	static::persist([static::$userMessi, static::$userManu, static::$userChaput, static::$userLP]);
    	
    	//
    	// Adresses
    	//
    	static::$ad_Tlse_Pech_Dav = TestOutils::createAdresse(08, 'Chemin des cotes de Pech David', 31400, 'Toulouse');
    	static::$ad_Monpipi = TestOutils::createAdresse(097, 'rue de la Fayette', 34400, 'Montpellier');
    	static::persist([static::$ad_Monpipi, static::$ad_Tlse_Pech_Dav]);
    	
    	// events
    	static::$event_heb_LP_auj = TestOutils::createEventFromAcc('event pour hebergement pour aujourdhui', null);
    	static::persist([static::$event_heb_LP_auj]);
    }
    
}
?>