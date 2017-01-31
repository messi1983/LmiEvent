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
use Lmi\CoreBundle\Constants\ConstClasses;
use Lmi\EventBundle\Tests\TestOutils;

/**
 * CarPoolingRepository Test class
 * @author Messi
 *
 */
class CarPoolingRepositoryTest extends AbstractRepositoryTest
{
	/**
	 * @var Lmi\EventBundle\Entity\CarPoolingRepository
	 */
	private static $carPoolingRepository;
	
	private static $event_heb_LP_auj;
	
	private static $event_heb_CF_auj;
	
	private static $userMessi;
	
	private static $userManu;
	
	private static $userChaput;
	
	private static $userLP;
	
	private static $tr_Bx_Tlse;
	
	private static $tr_Bx_Lyon;
	
	private static $dans_2h;
	
	private static $dans_3h;
	
	/**
	 * {@inheritDoc}
	 */
	public static function setUpBeforeClass() {
	
		parent::setUpBeforeClass();
	
        static::$carPoolingRepository = static::$em->getRepository(ConstClasses::CLASS_CAR_POOLING);
        
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
    	$covBxTlse_an_dernier = TestOutils::createCarPooling(new \DateTime('2015-05-10'), static::$userMessi, [static::$userChaput, static::$userLP], static::$tr_Bx_Tlse, static::$event_heb_LP_auj);
    	$covBxTlse_auj_2h_passee = TestOutils::createCarPooling((new \DateTime())->sub(new \DateInterval('PT2H')), static::$userMessi, [static::$userChaput, static::$userLP], static::$tr_Bx_Tlse, static::$event_heb_LP_auj);
    	$covBxTlse_auj_1h_passee = TestOutils::createCarPooling((new \DateTime())->sub(new \DateInterval('PT1H')), static::$userMessi, [static::$userChaput, static::$userLP], static::$tr_Bx_Tlse, static::$event_heb_LP_auj);
    	$covBxTlse_auj_dans_2h = TestOutils::createCarPooling(static::$dans_2h, static::$userMessi, [static::$userChaput, static::$userLP], static::$tr_Bx_Tlse, static::$event_heb_LP_auj);
    	$covBxTlse_auj_dans_3h = TestOutils::createCarPooling(static::$dans_3h, static::$userChaput, [static::$userMessi, static::$userLP], static::$tr_Bx_Tlse, static::$event_heb_LP_auj);
    	$covBxLyon_demain = TestOutils::createCarPooling((new \DateTime())->add(new \DateInterval('P1D')), static::$userManu, [static::$userChaput, static::$userLP], static::$tr_Bx_Lyon, static::$event_heb_LP_auj);
    	
    	static::persist([$covBxTlse_an_dernier, $covBxTlse_auj_2h_passee, $covBxTlse_auj_1h_passee, $covBxTlse_auj_dans_2h, $covBxTlse_auj_dans_3h, $covBxLyon_demain]);
    	 
    	//
    	//
    	 
    	// Execution méthode
        $result = static::$carPoolingRepository->findFromDate(date('Y-m-d'), 1, 6);
        $carPoolings = TestOutils::paginatorToArray($result);
        //
        //
        
        $this->assertNotNull($result);
        $this->assertCount(2, $result);
        
        $this->assertNotNull($carPoolings[0]->getDriver());
        $this->assertNotNull($carPoolings[1]->getDriver());
        $this->assertEquals(static::$userMessi, $carPoolings[0]->getDriver());
        $this->assertEquals(static::$userChaput, $carPoolings[1]->getDriver());
        
        $this->assertNotNull(1, $carPoolings[0]->getEvent());
        $this->assertNotNull(1, $carPoolings[1]->getEvent());
        $this->assertEquals(static::$event_heb_LP_auj, $carPoolings[0]->getEvent());
        $this->assertEquals(static::$event_heb_LP_auj, $carPoolings[1]->getEvent());
        
        $this->assertNotNull($carPoolings[0]->getDateDepart());
        $this->assertNotNull($carPoolings[1]->getDateDepart());
        $this->assertEquals(static::$dans_2h, $carPoolings[0]->getDateDepart());
        $this->assertEquals(static::$dans_3h, $carPoolings[1]->getDateDepart());
    }
    
    /**
     * findFromEventAndDate() method test
     */
    public function testFindFromEventAndDate()
    {
    	//
    	// Pre conditions
    	//
    	$covBxTlse_an_dernier = TestOutils::createCarPooling(new \DateTime('2015-05-10'), static::$userMessi, [static::$userChaput, static::$userLP], static::$tr_Bx_Tlse, static::$event_heb_CF_auj);
    	$covBxTlse_auj_2h_passee = TestOutils::createCarPooling((new \DateTime())->sub(new \DateInterval('PT2H')), static::$userMessi, [static::$userChaput, static::$userLP], static::$tr_Bx_Tlse, static::$event_heb_CF_auj);
    	$covBxTlse_auj_1h_passee = TestOutils::createCarPooling((new \DateTime())->sub(new \DateInterval('PT1H')), static::$userMessi, [static::$userChaput, static::$userLP], static::$tr_Bx_Tlse, static::$event_heb_CF_auj);
    	$covBxTlse_auj_dans_2h = TestOutils::createCarPooling(static::$dans_2h, static::$userMessi, [static::$userChaput, static::$userLP], static::$tr_Bx_Tlse, static::$event_heb_CF_auj);
    	$covBxTlse_auj_dans_3h = TestOutils::createCarPooling(static::$dans_3h, static::$userChaput, [static::$userMessi, static::$userLP], static::$tr_Bx_Tlse, null);
    	$covBxLyon_demain = TestOutils::createCarPooling((new \DateTime())->add(new \DateInterval('P1D')), static::$userManu, [static::$userChaput, static::$userLP], static::$tr_Bx_Lyon, static::$event_heb_CF_auj);
    	
    	static::persist([$covBxTlse_an_dernier, $covBxTlse_auj_2h_passee, $covBxTlse_auj_1h_passee, $covBxTlse_auj_dans_2h, $covBxTlse_auj_dans_3h, $covBxLyon_demain]);
    	
    	//
    	//
    	
    	// Execution méthode
    	$result = static::$carPoolingRepository->findFromEventAndDate(static::$event_heb_CF_auj->getId(), date('Y-m-d'), 1, 2);
    	$carPoolings = TestOutils::paginatorToArray($result);
    	
    	//
    	//
    	$this->assertNotNull($result);
    	$this->assertCount(1, $result);
    	
    	$this->assertNotNull($carPoolings[0]->getDriver());
    	$this->assertEquals(static::$userMessi, $carPoolings[0]->getDriver());
    	
    	$this->assertNotNull(1, $carPoolings[0]->getEvent());
    	$this->assertEquals(static::$event_heb_CF_auj, $carPoolings[0]->getEvent());
    	
    	$this->assertNotNull($carPoolings[0]->getDateDepart());
    	$this->assertEquals(static::$dans_2h, $carPoolings[0]->getDateDepart());
    }
    
    /**
     * BDD initialisation
     */
    private static function loadData()
    {
    	// dates
    	static::$dans_2h = (new \DateTime())->add(new \DateInterval('PT2H'));
    	static::$dans_3h = (new \DateTime())->add(new \DateInterval('PT3H'));
    	
    	//
    	// Users
    	//
    	static::$userMessi = TestOutils::createUser('Mario', 'mario.louis@yahoo.fr', 'merde');
    	static::$userManu = TestOutils::createUser('Manu', 'manu.louis@yahoo.fr', 'ok');
    	static::$userChaput = TestOutils::createUser('Chaput', 'chaput.louis@yahoo.fr', 'bruns');
    	static::$userLP = TestOutils::createUser('LE PIOUF', 'lpiouf.louis@yahoo.fr', 'bens');
    	static::persist([static::$userMessi, static::$userManu, static::$userChaput, static::$userLP]);
    	 
    	//
    	// Trajets
    	//
    	static::$tr_Bx_Tlse = TestOutils::createTrajet('Bordeaux', 'Toulouse');
    	static::$tr_Bx_Lyon = TestOutils::createTrajet('Bordeaux', 'Lyon');
    	static::persist([static::$tr_Bx_Tlse, static::$tr_Bx_Lyon]);
    	
    	// events
    	static::$event_heb_LP_auj = TestOutils::createEventFromAcc('event pour hebergement pour aujourdhui', null);
    	static::$event_heb_CF_auj = TestOutils::createEventFromAcc('event pour hebergement pour aujourdhui', null);
    	static::persist([static::$event_heb_CF_auj]);
    }
    
}
?>