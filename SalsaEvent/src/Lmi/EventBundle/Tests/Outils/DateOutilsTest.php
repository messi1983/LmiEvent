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
use Lmi\CoreBundle\Outils\DateOutils;
use Lmi\CoreBundle\Entity\Date;

/**
 * DateOutils Test class
 * @author Messi
 *
 */
class DateOutilsTest extends KernelTestCase
{	
    public function testCreateMaxDateTime()
    {
    	$date = new \DateTime('2016-05-10');
    	$now = new \DateTime();
    	
    	//
    	//
        $result1 = DateOutils::createMaxDateTime($date);
        $result2 = DateOutils::createMaxDateTime($now);
        
        //
        //
        $this->assertNotNull($result1);
        $this->assertNotNull($result2);
        $this->assertEquals('2016-05-10 23:59:59', $result1->format(Constants::DATE_TIME_FORMAT));
        $this->assertEquals($now->format(Constants::DEFAULT_DATE_FORMAT).' 23:59:59', $result2->format(Constants::DATE_TIME_FORMAT));
    }
    
    public function testCreateMinDateTime()
    {
    	$date = new \DateTime('2016-05-10');
    	$now = new \DateTime();
    	 
    	//
    	//
    	$result1 = DateOutils::createMinDateTime($date);
    	$result2 = DateOutils::createMinDateTime($now);
    
    	//
    	//
    	$this->assertNotNull($result1);
    	$this->assertNotNull($result2);
    	$this->assertEquals('2016-05-10 00:00:00', $result1->format(Constants::DATE_TIME_FORMAT));
    	$this->assertEquals($now->format(Constants::DEFAULT_DATE_FORMAT).' 00:00:00', $result2->format(Constants::DATE_TIME_FORMAT));
    }
    
    public function testReplaceOldDatesByCurrentDate()
    {
    	$far = $this->createDate('2016-05-10');
    	$yesterday = $this->createDate((new \DateTime())->sub(new \DateInterval('P1D'))->format(Constants::DEFAULT_DATE_FORMAT));
    	$today = $this->createDate((new \DateTime())->format(Constants::DEFAULT_DATE_FORMAT));
    	$tomorrow = $this->createDate((new \DateTime())->add(new \DateInterval('P1D'))->format(Constants::DEFAULT_DATE_FORMAT));
    	$in10Days = $this->createDate((new \DateTime())->add(new \DateInterval('P10D'))->format(Constants::DEFAULT_DATE_FORMAT));
    	
    	$listDates = array($far, $yesterday, $today, $tomorrow, $in10Days);
    	
    	//
    	//
    	
    	$resultList = DateOutils::replaceOldDatesByCurrentDate($listDates);
    	
    	//
    	//
    	$this->assertNotNull($resultList);
    	$this->assertCount(3, $resultList);
    	$this->assertEquals($today, $resultList[0]);
    	$this->assertEquals($tomorrow, $resultList[1]);
    	$this->assertEquals($in10Days, $resultList[2]);
    }
    
    private function createDate($value)
    {
    	$date = new Date();
    	$date->setDate($value);
    
    	return $date;
    }
}
?>