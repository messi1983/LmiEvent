<?php

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Lmi\EventBundle\Constants\Constants;
use Lmi\EventBundle\Entity\Event;
use Lmi\EventBundle\Entity\Periode;
use Lmi\EventBundle\Entity\Stage;
use Lmi\EventBundle\Entity\Soiree;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Lmi\EventBundle\Entity\CarPooling;
use Lmi\EventBundle\Entity\User;
use Lmi\EventBundle\Entity\Trajet;
use Lmi\EventBundle\Services\CarPoolingService;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

/**
 * CarPoolingRepository Test class
 * @author Messi
 *
 */
class CarPoolingRepositoryTest extends AbstractServiceTest
{
	/**
	 * @var Lmi\EventBundle\Services\CarPoolingService
	 */
	private static $carPoolingService;
	
	private static $event_cov_dans_2h;
	
	/**
	 * {@inheritDoc}
	 */
	public static function setUpBeforeClass() {
	
		parent::setUpBeforeClass();
	
        static::$carPoolingService = new CarPoolingService(static::$em);
        
        static::loadData();
	}
	
    public function testFindFromDate()
    {
        $result = static::$carPoolingService->findDates(7);
        
        //
        //
        $auj = (new \DateTime())->format(Constants::DEFAULT_DATE_FORMAT);
        $demain = (new \DateTime())->add(new \DateInterval('P1D'))->format(Constants::DEFAULT_DATE_FORMAT);
        
        $this->assertNotNull($result);
        $this->assertCount(2, $result);
        $this->assertEquals($auj, $result[0]->getDate());
        $this->assertEquals($demain, $result[1]->getDate());
    }
    
    public function testFindFromEventAndDate()
    {
    	$result = static::$carPoolingService->findDatesFromEvent(static::$event_cov_dans_2h->getId(), 7);
    
    	//
    	//
    	$auj = (new \DateTime())->format(Constants::DEFAULT_DATE_FORMAT);
    	
    	$this->assertNotNull($result);
    	$this->assertCount(1, $result);
    	$this->assertEquals($auj, $result[0]->getDate());
    }
    
    /**
     * BDD Initialisation
     */
    private static function loadData()
    {
    	//
    	// Users
    	//
    	$userMessi = static::createUser('Mario', 'mario.louis@yahoo.fr', 'merde');
    	$userManu = static::createUser('Manu', 'manu.louis@yahoo.fr', 'ok');
    	$userChaput = static::createUser('Chaput', 'chaput.louis@yahoo.fr', 'bruns');
    	$userLP = static::createUser('LE PIOUF', 'lpiouf.louis@yahoo.fr', 'bens');
    	 
    	//
    	// Trajets
    	//
    	$tr_Bx_Tlse = static::createTrajet('Bordeaux', 'Toulouse');
    	$tr_Bx_Lyon = static::createTrajet('Bordeaux', 'Lyon');
    	
    	//
    	// Covoiturages
    	//
    	$covBxTlse_an_dernier = static::createCarPooling(new \DateTime('2015-05-10'), $userMessi, [$userChaput, $userLP], $tr_Bx_Tlse);
    	$covBxTlse_auj_2h_passee = static::createCarPooling((new \DateTime())->sub(new \DateInterval('PT2H')), $userMessi, [$userChaput, $userLP], $tr_Bx_Tlse);
    	$covBxTlse_auj_1h_passee = static::createCarPooling((new \DateTime())->sub(new \DateInterval('PT1H')), $userMessi, [$userChaput, $userLP], $tr_Bx_Tlse);
    	$covBxTlse_auj_dans_2h = static::createCarPooling((new \DateTime())->add(new \DateInterval('PT2H')), $userMessi, [$userChaput, $userLP], $tr_Bx_Tlse);
    	$covBxTlse_auj_dans_3h = static::createCarPooling((new \DateTime())->add(new \DateInterval('PT3H')), $userMessi, [$userChaput, $userLP], $tr_Bx_Tlse);
    	$covBxLyon_demain = static::createCarPooling((new \DateTime())->add(new \DateInterval('P1D')), $userManu, [$userChaput, $userLP], $tr_Bx_Lyon);
    	 
    	// events
    	$event_cov_an_dernier = static::createEventFromCarPoolings('event pour covoiturage an dernier', [$covBxTlse_an_dernier]);
    	$event_cov_passe_depuis_1h = static::createEventFromCarPoolings('event pour cov passe depuis 1h', [$covBxTlse_auj_1h_passee]);
    	static::$event_cov_dans_2h = static::createEventFromCarPoolings('event pour cov dans 2h', [$covBxTlse_auj_dans_2h, $covBxTlse_auj_2h_passee]);
    	$event_cov_dans_3h = static::createEventFromCarPoolings('event pour cov dans 3h', [$covBxTlse_auj_dans_3h]);
    	$event_cov_demain = static::createEventFromCarPoolings('event auj a demain', [$covBxLyon_demain]);
    	 
    	static::persist([$event_cov_an_dernier, $event_cov_passe_depuis_1h, static::$event_cov_dans_2h, $event_cov_dans_3h, $event_cov_demain]);
    }
    
}
?>