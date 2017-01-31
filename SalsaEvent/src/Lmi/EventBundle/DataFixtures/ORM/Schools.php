<?php
namespace Lmi\EventBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Lmi\CoreBundle\Entity\Periode;
use Lmi\CoreBundle\Entity\Event;
use Lmi\CoreBundle\Entity\Soiree;
use Lmi\CoreBundle\Entity\Adresse;
use Lmi\CoreBundle\Entity\DanceSchool;
use Lmi\CoreBundle\Entity\CarPooling;
use Lmi\CoreBundle\Entity\Trajet;
use Lmi\CoreBundle\Entity\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Lmi\CoreBundle\Entity\User;
use Lmi\CoreBundle\Entity\Accommodation;
use Lmi\CoreBundle\Entity\Stage;
 
class Schools implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
  	
  	//
  	// Dance schools
  	//
  	$dkb = $this->createDanceSchool('DKB', 'Societe', 
  			$this->createAdresse(14, 'rue des 4 Castera', 33130, 'Begles'), ['Salsa', 'Kizomba', 'Bachata', 'Semba']);
//   	$alatica->setLogo($this->createImage('auteur_logo.jpg'));
  	
  	$punta = $this->createDanceSchool('Punta', 'Association', 
  			$this->createAdresse(56, 'Chemin des cotes de Pech David', 31400, 'Toulouse'), ['Salsa', 'Kizomba', 'Bachata', 'Swing']);
  	
  	$cohiba = $this->createDanceSchool('Cobiba', 'Association', 
  			$this->createAdresse(23, 'Rue Charles Domercd', 33000, 'Bordeaux'), ['Salsa', 'Kizomba', 'Bachata', 'Tango']);
  	
	
	// On déclenche l'enregistrement
	$manager->persist($dkb);
	$manager->persist($punta);
	$manager->persist($cohiba);
    $manager->flush();
  }
  
  private function createDanceSchool($name, $type, $adresse, $danses) 
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
  
  private function createAdresse($num, $rue, $codePostal, $ville) 
  {
  	$adresse = new Adresse();
  	$adresse->setNumero($num);
  	$adresse->setRue($rue);
  	$adresse->setCodePostal($codePostal);
  	$adresse->setVille($ville);
  	
  	return $adresse;
  }
  
  private function createUser($userName, $email, $passw) {
  	$user = new User();
  	$user->setUsername($userName);
  	$user->setEmail($email);
  	$user->setPassword($passw);
  	
  	return $user;
  }
  
  private function createImage($imageName)
  {
  	$image = new Image;
  	$image->setFile(new UploadedFile(__DIR__.'\\images\\'.$imageName, $imageName));
  	 
  	return $image;
  }
  
}
?>