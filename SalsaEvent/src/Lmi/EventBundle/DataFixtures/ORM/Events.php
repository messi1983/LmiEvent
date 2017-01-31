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
use Lmi\CoreBundle\Entity\Accommodation;
use Lmi\CoreBundle\Entity\Stage;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Lmi\CoreBundle\Entity\User;
use Lmi\CoreBundle\Entity\BankAccount;
use Lmi\CoreBundle\Tests\TestOutils;
 
class Events implements FixtureInterface
{
	private $encoder;
	
	private $em;
	
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
  	$this->encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
  	$this->em = $manager;
  	
  	//
  	// periodes
  	//
  	$pPassee = TestOutils::createPastPeriode('2016-05-10','2016-05-10' );
  	$pFiniDans2h = TestOutils::createCurrentPeriode('P1D', 'PT2H');
  	$pDebutDans2h = TestOutils::createFuturPeriode('PT2H', 'PT6H');
  	$pDebutDemain = TestOutils::createFuturPeriode('P1D', 'P1DT6H');
  	$pDebutDans10j = TestOutils::createFuturPeriode('P10D', 'P10DT6H');
  	
  	$this->persist([$pPassee, $pFiniDans2h, $pDebutDans2h, $pDebutDemain, $pDebutDans10j]);
  	
  	//
  	// Adresses
  	//
  	$adr_begles = TestOutils::createAdresse(98, 'rue des 4 Castera', 33130, 'Begles');
  	$adr_tlse = TestOutils::createAdresse(08, 'Chemin des cotes de Pech David', 31400, 'Toulouse');
  	$adr_bx = TestOutils::createAdresse(08, 'Rue Charles Domercd', 33000, 'Bordeaux');
  	
  	$this->persist([$adr_begles, $adr_tlse, $adr_bx]);
  	
  	//=======================================================================
  	// Soirees
  	//=======================================================================
  	$soireePassee = TestOutils::createSoiree('Soirée Bachata', $pPassee, 'Soiree Salsa', ['Salsa'], null);
  	$soireeKizEnCours = TestOutils::createSoiree('Soirée Kiz Alatica', $pFiniDans2h, 'Soiree Kiz', ['Salsa', 'Kiz'], $adr_begles);
  	$soireeSalsaDans2h = TestOutils::createSoiree('Soirée Salsa Que Calor', $pDebutDans2h, 'Soiree Salsa', ['Salsa'], $adr_bx);
  	$soireeKizDemain = TestOutils::createSoiree('Soirée Kizomba', $pDebutDemain, 'Soiree Kiz', ['Kizomba'], $adr_tlse);
  	$soireeKizDans10j = TestOutils::createSoiree('Soirée Sexy Kizomba', $pDebutDans10j, 'Soiree Kiz', ['Kizomba'], null);
  	$soireeBooDans10j = TestOutils::createSoiree('Soirée Sexy Boogie', $pDebutDans10j, 'Soiree Boogie', ['Boogie'], null);
  	
  	$this->persist([$soireePassee, $soireeKizEnCours, $soireeSalsaDans2h, $soireeKizDemain, $soireeKizDans10j, $soireeBooDans10j]);
  	
  	//=======================================================================
  	// Stages
  	//=======================================================================
  	$stageSalsa = TestOutils::createStage('Salsa', $pDebutDans2h, 'Stage d\'initiation');
  	$stageKiz = TestOutils::createStage('Kizomba', $pDebutDans2h, 'Stage d\'initiation');
  	 
  	$this->persist([$stageSalsa, $stageKiz]);
  	
  	//=======================================================================
  	// Organisateurs
  	//=======================================================================
  	$alatica = TestOutils::createDanceSchool('Alatica', 'Societe', 
  						$adr_begles, ['Salsa', 'Kizomba', 'Bachata']);
//   	$alatica->setLogo($this->createImage('auteur_logo.jpg'));
  	
  	$latKonnexion = TestOutils::createDanceSchool('Latin Connexion', 'Association', 
  						$adr_tlse, ['Salsa', 'Kizomba', 'Bachata']);
  	
  	$salsasita = TestOutils::createDanceSchool('Salsasita', 'Association', 
  						$adr_bx, ['Salsa', 'Kizomba', 'Bachata']);
  	
  	$this->persist([$alatica, $latKonnexion, $salsasita]);
  	
  	//=======================================================================
  	// Users
  	//=======================================================================
  	$userMessi = TestOutils::createUser('Mario', 'mario.louis@yahoo.fr', 'mario');
  	$userManu = TestOutils::createUser('Manu', 'manu.louis@yahoo.fr', 'manu');
  	$userChaput = TestOutils::createUser('Chaput', 'chaput.louis@yahoo.fr', 'chaput');
  	$userLP = TestOutils::createUser('LE PIOUF', 'lpiouf.louis@yahoo.fr', 'lepiouf');
  	
  	$this->persist([$userMessi, $userManu, $userChaput, $userLP]);
  	
  	//=======================================================================
  	// Users BankAccount
  	//=======================================================================
  	 $messiBankAccount = TestOutils::createBankAccount($userMessi, 'FR7630001007941234567890185', 'CRLYFRXXX');
  	 
  	 $this->persist([$messiBankAccount]);
  	 
//   	//=======================================================================
//   	// Covoiturages
//   	//=======================================================================
//   	$tr_Bx_Tlse = TestOutils::createTrajet('Bordeaux', 'Toulouse');
//   	$tr_Bx_Lyon = TestOutils::createTrajet('Bordeaux', 'Lyon');
  	
//   	$covBxTlse = TestOutils::createCarPooling(new \DateTime(), $userMessi, [$userChaput, $userLP], $tr_Bx_Tlse, null);
//   	$covBxTlse_bis = TestOutils::createCarPooling((new \DateTime())->add(new \DateInterval('PT2H')), $userMessi, [$userChaput, $userLP], $tr_Bx_Tlse, null);
//   	$covBxLyon = TestOutils::createCarPooling((new \DateTime())->add(new \DateInterval('PT2H')), $userManu, [$userChaput, $userLP], $tr_Bx_Lyon, null);
  	
//   	$this->persist([$covBxTlse, $covBxTlse_bis, $covBxLyon]);
  	
//   	//=======================================================================
//   	// Hebergements
//   	//=======================================================================
//   	$heb_LP = TestOutils::createAccommodation('C', $pDebutDans10j, 
//   						TestOutils::createAdresse(08, 'Chemin des cotes de Pech David', 31400, 'Toulouse'), 
//   						$userLP, [$userChaput, $userMessi], null);
  	
//   	$heb_Hotel = TestOutils::createAccommodation('H', $pDebutDans10j,
//   						TestOutils::createAdresse(097, 'rue de la Fayette', 34400, 'Montpellier'),
//   						$userChaput, [$userManu, $userLP], null);
  	
//   	$this->persist([$heb_LP, $heb_Hotel]);
  	
  	//=======================================================================
	// events
	//=======================================================================
  	$ePasse = TestOutils::createEvent('Evenement avorte', [$soireePassee], [], [$latKonnexion], [], []);
  	$eKizEnCours = TestOutils::createEvent('Soiree Pizza fini dans 2h', [$soireeKizEnCours], [], [$alatica], [], []);
  	$eSalsaDans2h = TestOutils::createEvent('Soiree Lambda debute dans 2h', [$soireeSalsaDans2h], [$stageKiz, $stageSalsa], [$alatica], [/*$covBxTlse, $covBxTlse_bis*/], []);
  	$eKzDemain = TestOutils::createEvent('Soirée Nikon pour demain', [$soireeKizDemain], [], [$salsasita], [], [/*$heb_LP*/]);
	$eBoogieDs10j = TestOutils::createEvent('Festival All Star dans 10 jours', [$soireeKizDans10j, $soireeBooDans10j], [], [$salsasita], [/*$covBxLyon*/], [/*$heb_Hotel*/]);
	
	$this->persist([$eKizEnCours, $eSalsaDans2h, $ePasse, $eKzDemain, $eBoogieDs10j]);
  }
  
  private function persist($beans)
  {
  	foreach ($beans as $bean) {
  		$this->em->persist($bean);
  	}
  	$this->em->flush();
  }
  
  private function createImage($imageName)
  {
  	$image = new Image;
  	$image->setFile(new UploadedFile(__DIR__.'\\images\\'.$imageName, $imageName));
  	 
  	return $image;
  }
  
}
?>