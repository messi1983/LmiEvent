<?php
namespace Lmi\EventBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Lmi\EventBundle\Entity\User;
use Lmi\EventBundle\Constants\Constants;
use Lmi\EventBundle\Constants\ConstClasses;

/**
 * User manager class
 */
class UserManager
{
	/** last update storage file. */
	const ADMIN_USER_STORAGE_FILE = "admin_2002_2013.txt";
	
	const ENCODER_ALGORITHM = "sha512";
	
	const ADMIN_INFOS_SEPARATORS = "[/:]";
	
	const ADMIN_EMAIL = 'messi_louis@yahoo.fr';
	
	/**
	 * Entity manager
	 */
	protected $em;
	
	/**
	 * Constructor
	 */
	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}
	
	/**
	 * Allow to persists a bean
	 * @param \Lmi\EventBundle\Entity\User $user
	 */
	public function saveOrUpdate($user)
	{
		// Save or update
		if($user->getId() === null) {
			$this->em->persist($user);
		}
		$this->em->flush();
	
		return $this;
	}
	
	/**
	 * update Admin Authentification Infos.
	 */
	public function updateAdminAuthInfos() {
	
		if(file_exists ($this::ADMIN_USER_STORAGE_FILE)) {
			// open file
			$adminAuthInfosStorageFile = fopen($this::ADMIN_USER_STORAGE_FILE, Constants::FILE_READ_ONLY_MODE);
	
			// read the first and unique line
			$rootAuthInfos = fgets($adminAuthInfosStorageFile);
	
			// Close the file
			fclose($adminAuthInfosStorageFile);
				
			list($rootId, $rootPassword) = split($this::ADMIN_INFOS_SEPARATORS, $rootAuthInfos);
				
			// create or update admin user
			if($this->createOrUpdateAdminUser($rootId, $rootPassword)) {
				// Deletion of the file after reading
				unlink($this::ADMIN_USER_STORAGE_FILE) ;
			}
		}
		return $this;
	}
	
	/**
	 * Create or update admin user
	 * @param unknown $rootLogin
	 * @param unknown $rootPassword
	 */
	private function createOrUpdateAdminUser($rootLogin, $rootPassword) {
		$result = false;
		$userRepository = $this->em->getRepository(Constants::USER_CLASS);
	
		// Take all users in database
		$users = $userRepository->findAll();
	
		// count nb users
		$nbUsersFound = sizeof($users);
	
		$adminUser = null;
	
		switch ($nbUsersFound) {
			case 0:
				// Creation of a new admin user
				$adminUser = new User;
				break;
	
			case 1:
				$adminUser = $users[0];
				break;
					
			default:
				// user table cleaned
				foreach ($users as $user) {
					$this->em->remove($user);
				}
				$this->em->flush();
	
				// Creation of a new admin user
				$adminUser = new User;
		}
	
		// encoder initalization
		$encoder = new MessageDigestPasswordEncoder($this::ENCODER_ALGORITHM, true, 10);
	
		// unchanged data
		$adminUser->setEmail($this::ADMIN_EMAIL);
		$adminUser->setRoles(array(Constants::ROLE_ADMIN));
		$adminUser->setEnabled(true);
		$adminUser->setUsername($rootLogin);
		$adminUser->setPassword($encoder->encodePassword($rootPassword, $adminUser->getSalt()));
	
		// Password validation
		$validPassword = $encoder->isPasswordValid($adminUser->getPassword(), $rootPassword, $adminUser->getSalt());
	
		if($validPassword) {
			if($adminUser->getId() === null) {
				$this->em->persist($adminUser);
			}
			$this->em->flush();
			$result = true;
		}
	
		return $result;
	}
	
	/** 
	 * Find user by its login
	 * @param unknown $username
	 * @return object
	 */
	public function findByLogin($username) {
		$userRepository = $this->em->getRepository(ConstClasses::USER_CLASS);
		return $userRepository->findOneBy(array('username' => $username));
	}
}
?>

