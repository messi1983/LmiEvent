<?php

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Lmi\CoreBundle\Entity\Event;
use Lmi\CoreBundle\Entity\Soiree;
use Lmi\CoreBundle\Entity\Stage;
use Lmi\CoreBundle\Entity\Periode;
use Lmi\CoreBundle\Constants\Constants;
use Lmi\CoreBundle\Entity\User;
use Lmi\CoreBundle\Entity\Adresse;
use Lmi\CoreBundle\Entity\DanceSchool;
use Lmi\EventBundle\Services\DanceSchoolService;
use Lmi\CoreBundle\Constants\ConstClasses;
use Lmi\EventBundle\Tests\TestOutils;
/**
 * 
 * @author Messi
 *
 */
class DanceSchoolRepositoryTest extends AbstractRepositoryTest
{
	/**
	 * @var Lmi\EventBundle\Entity\DanceSchoolRepository
	 */
	private  static $danceSchoolRepository;
	
	/**
	 * {@inheritDoc}
	 */
	public static function setUpBeforeClass() {
	
		parent::setUpBeforeClass();
	
        static::$danceSchoolRepository = static::$em->getRepository(ConstClasses::CLASS_DANCE_SCHOOL);
	}
	
	/**
	 * findAllDanceSchools() test method
	 */
    public function testFindAllDanceSchools()
    {
    	//
    	// Pre conditions
    	//
    	$dkb = TestOutils::createDanceSchool('DKB', 'Societe',
    			TestOutils::createAdresse(14, 'rue des 4 Castera', 33130, 'Begles'), ['Salsa', 'Kizomba', 'Bachata', 'Semba']);
    	
    	$punta = TestOutils::createDanceSchool('Punta', 'Association',
    			TestOutils::createAdresse(56, 'Chemin des cotes de Pech David', 31400, 'Toulouse'), ['Salsa', 'Kizomba', 'Bachata', 'Swing']);
    	
    	$cohiba = TestOutils::createDanceSchool('Cobiba', 'Association',
    			TestOutils::createAdresse(23, 'Rue Charles Domercd', 33000, 'Bordeaux'), ['Salsa', 'Kizomba', 'Bachata', 'Tango']);
    	
    	static::persist([$dkb, $punta, $cohiba]);

    	//
    	//
    	
    	// Execution méthode
    	$result = static::$danceSchoolRepository->findAllDanceSchools(1, 10);
    	//
    	//
    	
    	// result checking
    	$this->assertNotNull($result);
    	$this->assertCount(3, $result);
    }
    
}
?>