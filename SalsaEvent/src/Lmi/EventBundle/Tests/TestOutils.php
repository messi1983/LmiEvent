<?php
namespace Lmi\EventBundle\Tests;

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
use Lmi\EventBundle\Entity\Accommodation;
use Lmi\EventBundle\Entity\Adresse;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Lmi\EventBundle\Entity\DanceSchool;

/**
 * Test utilitarian
 * @author Messi
 *
 */
class TestOutils
{
	/**
	 * Constructor
	 */
	private function __construct()
	{
	}
	
	public static function paginatorToArray($paginator) {
		if($paginator === null) {
			return null;
		}
		
		$array = array();
		foreach($paginator->getIterator() as $elemnt) {
			$array[] = $elemnt;
		}
		return $array;
	}
    
	/**
	 * Crée un utilisateur
	 * @param unknown $userName
	 * @param unknown $email
	 * @param unknown $passw
	 * @return \Lmi\EventBundle\Entity\User
	 */
	public static function createUser($userName, $email, $passw) {
    	$user = new User();
    	$user->setUsername($userName);
    	$user->setFirstname($userName);
    	$user->setLastname($userName);
    	$user->setEmail($email);
    	$user->setPassword($passw);
    	$user->setRoles(array('ROLE_AUTEUR'));
    	$user->setEnabled(true);
    	 
    	return $user;
    }
    
    /**
     * Crée une adresse
     * @param unknown $num
     * @param unknown $rue
     * @param unknown $codePostal
     * @param unknown $ville
     * @return \Lmi\EventBundle\Entity\Adresse
     */
    public static function createAdresse($num, $rue, $codePostal, $ville)
    {
    	$adresse = new Adresse();
    	$adresse->setNumero($num);
    	$adresse->setRue($rue);
    	$adresse->setCodePostal($codePostal);
    	$adresse->setVille($ville);
    
    	return $adresse;
    }
    
    /**
     * Crée un evenement via une liste de covoiturages
     * @param unknown $identification
     * @param unknown $covoiturages
     * @return \Lmi\EventBundle\Entity\Event
     */
    public static function createEventFromCarPoolings($identification, $covoiturages)
    {
    	$event = new Event();
    	$event->setIdentification($identification);
    	$event->setPublication(true);
    
    	foreach ($covoiturages as $covoiturage) {
    		$event->addCarpooling($covoiturage);
    	}
    	return $event;
    }
    
    /**
     * Crée un evenement via une liste de soirées et une liste de stages
     * @param unknown $identification
     * @param unknown $soirees
     * @param unknown $stages
     * @return \Lmi\EventBundle\Entity\Event
     */
    public static function createEvent($identification, $soirees, $stages)
    {
    	$event = new Event();
    	$event->setIdentification($identification);
    	$event->setPublication(true);
    
    	foreach ($soirees as $soiree) {
    		$event->addSoiree($soiree);
    	}
    	foreach ($stages as $stage) {
    		$event->addStage($stage);
    	}
    	return $event;
    }
    
    /**
     * Crée un evenement via une liste d'hebergements
     * @param unknown $identification
     * @param unknown $hebergements
     * @return \Lmi\EventBundle\Entity\Event
     */
    public static function createEventFromAcc($identification, $hebergements)
    {
    	$event = new Event();
    	$event->setIdentification($identification);
    	$event->setPublication(true);
    
    	if($hebergements !== null) {
	    	foreach ($hebergements as $hebergement) {
	    		$event->addHebergement($hebergement);
	    	}
    	}
    	return $event;
    }
    
    /**
     * Crée un covoiturage
     * @param unknown $dateDepart
     * @param unknown $driver
     * @param unknown $carpoolers
     * @param unknown $trajet
     * @param unknown $event
     * @return \Lmi\EventBundle\Entity\CarPooling
     */
    public static function createCarPooling($dateDepart, $driver, $carpoolers, $trajet, $event)
    {
    	$cov = new CarPooling();
    	$cov->setPublication(true);
    	$cov->setDateDepart($dateDepart);
    	$cov->setDriver($driver);
    	$cov->setEvent($event);
    
    	foreach ($carpoolers as $carpooler) {
    		$cov->addCarpooler($carpooler);
    	}
    	$cov->setNbPlaces(4);
    	$cov->setTrajet($trajet);
    	return $cov;
    }
    
    /**
     * Crée un trajet
     * @param unknown $villeDepart
     * @param unknown $villeArrivee
     * @return \Lmi\EventBundle\Entity\Trajet
     */
    public static function createTrajet($villeDepart, $villeArrivee)
    {
    	$trajet = new Trajet();
    	$trajet->setVilleDepart($villeDepart);
    	$trajet->setVilleArrivee($villeArrivee);
    
    	return $trajet;
    }
    
    /**
     * Crée un hébergement
     * @param unknown $type
     * @param unknown $periode
     * @param unknown $adresse
     * @param unknown $host
     * @param unknown $tenants
     * @param unknown $event
     * @return \Lmi\EventBundle\Entity\Accommodation
     */
    public static function createAccommodation($type, $periode, $adresse, $host, $tenants, $event)
    {
    	$heb = new Accommodation();
    	$heb->setType($type);
    	$heb->setAdresse($adresse);
    	$heb->setPeriode($periode);
    	$heb->setHost($host);
    	$heb->setNbPlaces(4);
    	$heb->setPublication(true);
    	$heb->addEvent($event);
    
    	foreach ($tenants as $tenant) {
    		$heb->addTenant($tenant);
    	}
    	return $heb;
    }
    
    public static function createFuturPeriode($debut, $fin) {
    	$periode = new Periode();
    	$periode->setDateDebut((new \DateTime())->add(new \DateInterval($debut)));
    	$periode->setDateFin((new \DateTime())->add(new \DateInterval($fin)));
    
    	return $periode;
    }
    
    public static function createCurrentPeriode($debut, $fin) {
    	$periode = new Periode();
    	$periode->setDateDebut((new \DateTime())->sub(new \DateInterval($debut)));
    	$periode->setDateFin((new \DateTime())->add(new \DateInterval($fin)));
    
    	return $periode;
    }
    
    public static function createPastPeriode($debut, $fin) {
    	$periode = new Periode();
    	$periode->setDateDebut(new \DateTime($debut));
    	$periode->setDateFin(new \DateTime($fin));
    
    	return $periode;
    }
    
    public static function createDanceSchool($name, $type, $adresse, $danses)
    {
    	$dSchool = new DanceSchool();
    	$dSchool->setAdresse($adresse);
    	$dSchool->setNom($name);
    	$dSchool->setType($type);
    	$dSchool->setPublication(true);
    
    	foreach ($danses as $danse) {
    		$dSchool->addDanse($danse);
    	}
    
    	return $dSchool;
    }
    
    public static function createSoiree($ident, $periode, $descriptif, $ambiances, $adresse)
    {
    	$soiree = new Soiree();
    	$soiree->setDates($periode);
    	$soiree->setIdentification($ident);
    	$soiree->setDesciptif($descriptif);
    	$soiree->setProgramme('Programe 2');
    	$soiree->setAmbiances($ambiances);
    	$soiree->setAdresse($adresse);
    
    	return $soiree;
    }
    
    public static function createStage($danse, $dates, $desciptif)
    {
    	$stage = new Stage();
    	$stage->setDanse($danse);
    	$stage->setDates($dates);
    	$stage->setDesciptif($desciptif);
    	return $stage;
    }

}
?>