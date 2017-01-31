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
use Lmi\CoreBundle\Entity\DanceSchool;

/**
 * AbstractRepository Test class
 * @author Messi
 *
 */
abstract class AbstractRepositoryTest extends KernelTestCase
{
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected static $em;
	
	protected static $encoder;
	
	/**
	 * {@inheritDoc}
	 */
	public static function setUpBeforeClass() {
	
		parent::setUpBeforeClass();
	
		self::bootKernel();
		
		static::$encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
		
		static::$em = static::$kernel->getContainer()->get('doctrine')->getManager();
        $schemaTool = new SchemaTool(static::$em);
        $metadata = static::$em->getMetadataFactory()->getAllMetadata();

        // Drop and recreate tables for all entities
        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);
	}
    
    /**
     * {@inheritDoc}
     */
    public static function tearDownAfterClass()
    {
    	parent::tearDownAfterClass();
    	
    	static::purgeBDD();
    
    	if(static::$em !== null) {
    		static::$em->close();
    		static::$em = null; // avoid memory leaks
    	}
    }
    
    protected static function persist($elements) 
    {
    	foreach ($elements as $element) {
    		static::$em->persist($element);
    	}
    	static::$em->flush();
    }
    
    protected static function remove($elements)
    {
    	foreach ($elements as $element) {
    		static::$em->remove($element);
    	}
    	static::$em->flush();
    }
    
    protected static function purgeBDD()
    {
    	$purger = new ORMPurger(static::$em);
    	$purger->setPurgeMode(ORMPurger::PURGE_MODE_DELETE);
    	$purger->purge();
    }
    
}
?>