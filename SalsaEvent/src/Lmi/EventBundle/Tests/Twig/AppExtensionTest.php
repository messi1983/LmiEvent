<?php

use Lmi\EventBundle\Services\EventService;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Lmi\EventBundle\Twig\AppExtension;
use Lmi\CoreBundle\Entity\Event;
use Lmi\CoreBundle\Entity\Soiree;
use Lmi\CoreBundle\Entity\Stage;
use Lmi\CoreBundle\Entity\Periode;

/**
 * 
 * @author Messi
 *
 */
class AppExtensionTest extends TestCase
{
	/**
	 * @var Lmi\EventBundle\Twig\AppExtension
	 */
	private $appExtension;
	
	/**
	 * {@inheritDoc}
	 */
	protected function setUp()
	{
		$this->appExtension  = new AppExtension();
	}
	
    public function testSoireeFilter()
    {
    	// periodes
        $pSoiree1 = $this->createPeriode('2016-05-10', '2016-05-11');
        $pSoiree2 = $this->createPeriode('2016-05-12', '2016-05-13');
        $pSoiree3 = $this->createPeriode('2016-05-14', '2016-05-15');
        
        // soirees
        $soiree1 = $this->createSoiree('Soirée 1', $pSoiree1, 'Soiree', ['Salsa'], null);
        $soiree2 = $this->createSoiree('Soirée 2', $pSoiree2, 'Soiree', ['Salsa'], null);
        $soiree3 = $this->createSoiree('Soirée 3', $pSoiree3, 'Soiree', ['Salsa'], null);
        
        // event with the 3 soirees
        $event = $this->createEvent([$soiree1, $soiree2, $soiree3], []);
        
        //
        //
        
        $result1 = $this->appExtension->soireeFilter($event, '12/05/2016');
        $result2 = $this->appExtension->soireeFilter($event, '10/05/2016');
        $result3 = $this->appExtension->soireeFilter($event, '14/05/2016');
        
        //
        //

        $this->assertEquals($soiree2, $result1);
        $this->assertEquals($soiree1, $result2);
        $this->assertEquals($soiree3, $result3);
    }
    
    public function testPeriodeFilter()
    {
    	// periodes
    	$pSoiree1 = $this->createPeriode('2016-05-10', '2016-05-11');
    	$pSoiree2 = $this->createPeriode('2016-05-12', '2016-05-13');
    	$pSoiree3 = $this->createPeriode('2016-05-14', '2016-05-15');
    	
    	$pStage1 = $this->createPeriode('2016-06-10', '2016-06-11');
    	$pStage2 = $this->createPeriode('2016-06-12', '2016-06-13');
    	$pStage3 = $this->createPeriode('2016-06-14', '2016-06-15');
    
    	// soirees
    	$soiree1 = $this->createSoiree('Soirée 1', $pSoiree1, 'Soiree', ['Salsa'], null);
    	$soiree2 = $this->createSoiree('Soirée 2', $pSoiree2, 'Soiree', ['Salsa'], null);
    	$soiree3 = $this->createSoiree('Soirée 3', $pSoiree3, 'Soiree', ['Salsa'], null);
    
    	// stages
    	$stage1 = $this->createStage('Stage 1', $pStage1, 'Stage');
    	$stage2 = $this->createStage('Stage 2', $pStage2, 'Stage');
    	$stage3 = $this->createStage('Stage 3', $pStage3, 'Stage');
    	
    	// event with the 3 soirees
    	$event = $this->createEvent([$soiree1, $soiree2, $soiree3], [$stage1, $stage2, $stage3]);
    
    	//
    	//
    
    	$result1 = $this->appExtension->periodeFilter($event, 'soiree');
    	$result2 = $this->appExtension->periodeFilter($event, 'stage');
    
    	//
    	//
    
    	$this->assertNotNull($result1);
    	$this->assertEquals($pSoiree1->getDateDebut(), $result1->getDateDebut());
    	$this->assertEquals($pSoiree3->getDateFin(), $result1->getDateFin());
    	
    	$this->assertNotNull($result2);
    	$this->assertEquals($pStage1->getDateDebut(), $result2->getDateDebut());
    	$this->assertEquals($pStage3->getDateFin(), $result2->getDateFin());
    	 
    }
    
    private function createEvent($soirees, $stages)
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
    
    private function createSoiree($ident, $periode, $descriptif, $ambiances, $adresse)
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
    
    private function createStage($danse, $dates, $desciptif)
    {
    	$stage = new Stage();
    	$stage->setDanse($danse);
    	$stage->setDates($dates);
    	$stage->setDesciptif($desciptif);
    	return $stage;
    }
    
    private function createPeriode($dateDebut, $dateFin)
    {
    	$periode = new Periode();
        $periode->setDateDebut(new \DateTime($dateDebut));
        $periode->setDateFin(new \DateTime($dateFin));
    
    	return $periode;
    }
}
?>