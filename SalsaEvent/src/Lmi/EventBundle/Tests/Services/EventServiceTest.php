<?php

use Lmi\EventBundle\Services\EventService;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Lmi\CoreBundle\Entity\Event;
use Lmi\CoreBundle\Entity\Soiree;
use Lmi\CoreBundle\Entity\Stage;
use Lmi\CoreBundle\Entity\Periode;
use Lmi\CoreBundle\Constants\Constants;
use Lmi\EventBundle\Twig\AppExtension;
/**
 * 
 * @author Messi
 *
 */
class EventServiceTest extends AbstractServiceTest
{
	/**
	 * @var Lmi\EventBundle\Services\EventService
	 */
	private  static $eventService;
	
	private static $pPassee;
	
	private static $pFiniDans2h;
	
	private static $pDebutDans2h;
	
	private static $pDebutDemain;
	
	private static $pDebutDans10j;
	
	/**
	 * {@inheritDoc}
	 */
	public static function setUpBeforeClass() {
	
		parent::setUpBeforeClass();
        
        static::$eventService = new EventService(static::$em, new AppExtension());
        
        static::loadData();
	}
	
    public function testFindDates()
    {
    	$result = static::$eventService->findDates(7);
    	
    	//
    	//
    	$auj = (new \DateTime())->format(Constants::DEFAULT_DATE_FORMAT);
    	$demain = static::$pDebutDemain->getDateDebut()->format(Constants::DEFAULT_DATE_FORMAT);
    	$dans10j = static::$pDebutDans10j->getDateDebut()->format(Constants::DEFAULT_DATE_FORMAT);
    	
    	$this->assertNotNull($result);
    	$this->assertCount(3, $result);
    	$this->assertEquals($auj, $result[0]->getDate());
    	$this->assertEquals($demain, $result[1]->getDate());
    	$this->assertEquals($dans10j, $result[2]->getDate());
    }
    
    /**
     * dateMin = current date
     */
    public function testFindDatesBetween1()
    {
    	$dans10j = (new \DateTime())->add(new \DateInterval('P10D'));
    	$auj = new \DateTime();
    	
    	$result = static::$eventService->findDatesBetween($auj, $dans10j);
    	 
    	//
    	//
    	$auj = (new \DateTime())->format(Constants::DEFAULT_DATE_FORMAT);
    	$demain = static::$pDebutDemain->getDateDebut()->format(Constants::DEFAULT_DATE_FORMAT);
    	$dans10j = static::$pDebutDans10j->getDateDebut()->format(Constants::DEFAULT_DATE_FORMAT);
    	 
    	 
    	$this->assertNotNull($result);
    	$this->assertCount(3, $result);
    	$this->assertEquals($auj, $result[0]->getDate());
    	$this->assertEquals($demain, $result[1]->getDate());
    	$this->assertEquals($dans10j, $result[2]->getDate());
    }
    
    /**
     * findDatesBetween() test method with datMin = tomorrow
     */
    public function testFindDatesBetween2()
    {
    	$dans10j = (new \DateTime())->add(new \DateInterval('P10D'));
    	$demain = (new \DateTime())->add(new \DateInterval('P1D'));
    	 
    	$result = static::$eventService->findDatesBetween($demain, $dans10j);
    
    	//
    	//
    	$demain = static::$pDebutDemain->getDateDebut()->format(Constants::DEFAULT_DATE_FORMAT);
    	$dans10j = static::$pDebutDans10j->getDateDebut()->format(Constants::DEFAULT_DATE_FORMAT);
    
    	$this->assertNotNull($result);
    	$this->assertCount(2, $result);
    	$this->assertEquals($demain, $result[0]->getDate());
    	$this->assertEquals($dans10j, $result[1]->getDate());
    }
    
    /**
     * BDD Initialisation
     */
    private static function loadData()
    {
    	//
    	// periodes
    	//
    	static::$pPassee = static::createPastPeriode('2016-05-10', '2016-05-11');
    	static::$pFiniDans2h = static::createCurrentPeriode('P1D', 'PT2H');
    	static::$pDebutDans2h = static::createFuturPeriode('PT2H', 'PT6H');
    	static::$pDebutDemain = static::createFuturPeriode('P1D', 'P1DT6H');
    	static::$pDebutDans10j = static::createFuturPeriode('P10D', 'P10DT6H');
    	
    	// soirees
    	$soiree1 = static::createSoiree('Soirée 1', static::$pPassee, 'Soiree', ['Salsa'], null);
    	$soiree2 = static::createSoiree('Soirée 2', static::$pFiniDans2h, 'Soiree', ['Salsa'], null);
    	$soiree3 = static::createSoiree('Soirée 3', static::$pDebutDans2h, 'Soiree', ['Salsa'], null);
    	$soiree4 = static::createSoiree('Soirée 5', static::$pDebutDemain, 'Soiree', ['Salsa'], null);
    	$soiree5 = static::createSoiree('Soirée 6', static::$pDebutDans10j, 'Soiree', ['Salsa'], null);
    	
    	// event with the 3 soirees
    	$event1 = static::createEvent([$soiree1], []);
    	$event2 = static::createEvent([$soiree2], []);
    	$event3 = static::createEvent([$soiree3], []);
    	$event4 = static::createEvent([$soiree4], []);
    	$event5 = static::createEvent([$soiree5], []);
    	
    	static::persist([$event1, $event2, $event3, $event4, $event5]);
    }
    
}
?>