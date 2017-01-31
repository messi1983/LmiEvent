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
use Lmi\EventBundle\Entity\Trajet;
use Lmi\EventBundle\Entity\CarPooling;

/**
 * AccommodationService test class
 * @author Messi
 *
 */
abstract class AbstractServiceTest extends KernelTestCase
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
    	 
    	$purger = new ORMPurger(static::$em);
    	$purger->setPurgeMode(ORMPurger::PURGE_MODE_DELETE);
    	$purger->purge();
    
    	if(static::$em !== null) {
    		static::$em->close();
    		static::$em = null; // avoid memory leaks
    	}
    }
    
	protected static function createUser($userName, $email, $passw) {
    	$user = new User();
    	$user->setUsername($userName);
    	$user->setFirstname($userName);
    	$user->setLastname($userName);
    	$user->setEmail($email);
    	$user->setPassword(static::$encoder->encodePassword($passw, $user->getSalt()));
    	$user->setRoles(array('ROLE_AUTEUR'));
    	$user->setEnabled(true);
    	 
    	return $user;
    }
    
    protected static function createFuturPeriode($debut, $fin) {
    	$periode = new Periode();
    	$periode->setDateDebut((new \DateTime())->add(new \DateInterval($debut)));
    	$periode->setDateFin((new \DateTime())->add(new \DateInterval($fin)));
    
    	return $periode;
    }
    
    protected static function createCurrentPeriode($debut, $fin) {
    	$periode = new Periode();
    	$periode->setDateDebut((new \DateTime())->sub(new \DateInterval($debut)));
    	$periode->setDateFin((new \DateTime())->add(new \DateInterval($fin)));
    
    	return $periode;
    }
    
    protected static function createPastPeriode($debut, $fin) {
    	$periode = new Periode();
    	$periode->setDateDebut(new \DateTime($debut));
    	$periode->setDateFin(new \DateTime($fin));
    
    	return $periode;
    }
    
    protected static function createAdresse($num, $rue, $codePostal, $ville)
    {
    	$adresse = new Adresse();
    	$adresse->setNumero($num);
    	$adresse->setRue($rue);
    	$adresse->setCodePostal($codePostal);
    	$adresse->setVille($ville);
    
    	return $adresse;
    }
    
    protected static function createAccommodation($type, $periode, $adresse, $host, $tenants)
    {
    	$heb = new Accommodation();
    	$heb->setType($type);
    	$heb->setAdresse($adresse);
    	$heb->setPeriode($periode);
    	$heb->setHost($host);
    	$heb->setNbPlaces(4);
    	$heb->setPublication(true);
    
    	foreach ($tenants as $tenant) {
    		$heb->addTenant($tenant);
    	}
    	return $heb;
    }
    
    protected static function createEventFromAcc($identification, $hebergements)
    {
    	$event = new Event();
    	$event->setIdentification($identification);
    	$event->setPublication(true);
    
    	foreach ($hebergements as $hebergement) {
    		$event->addHebergement($hebergement);
    	}
    	return $event;
    }
    
    protected static function createEvent($soirees, $stages)
    {
    	$event = new Event();
    	$event->setPublication(true);
    
    	foreach ($soirees as $soiree) {
    		$event->addSoiree($soiree);
    	}
    	foreach ($stages as $stage) {
    		$event->addStage($stage);
    	}
    	return $event;
    }
    
    protected static function createEventFromCarPoolings($identification, $covoiturages)
    {
    	$event = new Event();
    	$event->setIdentification($identification);
    	$event->setPublication(true);
    
    	foreach ($covoiturages as $covoiturage) {
    		$event->addCarpooling($covoiturage);
    	}
    	return $event;
    }
    
    protected static function createSoiree($ident, $periode, $descriptif, $ambiances, $adresse)
    {
    	$soiree = new Soiree();
    	$soiree->setDates($periode);
    	$soiree->setIdentification($ident);
    	$soiree->setDesciptif($descriptif);
    	$soiree->setProgramme('Programe 2');
    	$soiree->setAmbiances($ambiances);
    	$soiree->setAdresse($adresse);
    	$soiree->setPublication(true);
    
    	return $soiree;
    }
    
    protected static function createStage($danse, $dates, $desciptif)
    {
    	$stage = new Stage();
    	$stage->setDanse($danse);
    	$stage->setDates($dates);
    	$stage->setDesciptif($desciptif);
    	$stage->setPublication(true);
    	return $stage;
    }
    
    protected static function createCarPooling($dateDepart, $driver, $carpoolers, $trajet)
    {
    	$cov = new CarPooling();
    	$cov->setPublication(true);
    	$cov->setDateDepart($dateDepart);
    	$cov->setDriver($driver);
    
    	foreach ($carpoolers as $carpooler) {
    		$cov->addCarpooler($carpooler);
    	}
    	$cov->setNbPlaces(4);
    	$cov->setTrajet($trajet);
    	return $cov;
    }
    
    protected static function createTrajet($villeDepart, $villeArrivee)
    {
    	$trajet = new Trajet();
    	$trajet->setVilleDepart($villeDepart);
    	$trajet->setVilleArrivee($villeArrivee);
    
    	return $trajet;
    }
    
    protected static function persist($events) 
    {
    	foreach ($events as $event) {
    		static::$em->persist($event);
    	}
    	static::$em->flush();
    }
    
}
?>