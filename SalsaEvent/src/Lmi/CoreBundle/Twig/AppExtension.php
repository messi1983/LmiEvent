<?php
namespace Lmi\CoreBundle\Twig;

use Lmi\CoreBundle\Constants\Constants;
use Lmi\CoreBundle\Entity\Event;
use Lmi\CoreBundle\Entity\Periode;

/**
 * Twig extension
 * @author Messi
 *
 */
class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('soiree', array($this, 'soireeFilter')),
        	new \Twig_SimpleFilter('periode', array($this, 'periodeFilter')),
        );
    }
    
    /**
     * Find a soiree from its start date into an event
     * @param Event $event
     * @param unknown $date
     * @return \Doctrine\Common\Collections\Collection|NULL
     */
    public function soireeFilter(Event $event, $date)
    {
        if($event !== null) {
        	$dateInStr = null;
        	
			foreach($event->getSoirees() as $soiree) {
				if($soiree->getDateDebut() !== null) {
					$dateInStr = $soiree->getDateDebut()->format(Constants::FRENCH_DATE_FORMAT);
				}
				if($dateInStr === $date) {
					return $soiree;
				}
			}
		}
		return null;
    }
    
    /**
     * Get stage or soiree periode
     * @param unknown $event
     * @param unknown $typeEvent
     */
    public function periodeFilter($event, $typeEvent)
    {
    	$periode = null;
    	
    	if($event !== null) {
    		 $periode = new Periode();
    		 $list = null;
    		 
    		if($typeEvent === 'soiree') {
    			$list = $event->getSoirees();
    		} else {
    			$list = $event->getStages();
    		}
    		foreach($list as $event) {
    			if($periode->getDateDebut() === null || $periode->getDateDebut() > $event->getDateDebut()) {
    				$periode->setDateDebut($event->getDateDebut());
    			}
    			if($periode->getDateFin() === null || $periode->getDateFin() < $event->getDateFin()) {
    				$periode->setDateFin($event->getDateFin());
    			}
    		}
    	}
    	return $periode;
    }

    public function getName()
    {
        return 'app_extension';
    }
}
?>
