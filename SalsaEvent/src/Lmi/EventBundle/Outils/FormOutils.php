<?php
namespace Lmi\EventBundle\Outils;
use Lmi\EventBundle\Constants\Constants;

/**
 * Form utils class
 */
class  FormOutils
{	
	/**
	 * Constructor
	 */
	private function __construct()
	{
	}
	
	/**
	 * Create and return sexes list.
	 * @return array
	 */
	public static function getSexesList() 
	{
		$sexes = array(
			'M'    => 'Homme',
			'F'    => 'Femme'
		);
		return $sexes;
	}
	
	/**
	 * Create and return danses list.
	 * @return array
	 */
	public static function getDansesList()
	{
		$ambiances = array(
			'salsa'    => 'Salsa',
			'kizomba'  => 'Kizomba',
			'bachata'  => 'Bachata'
		);
		return $ambiances;
	}
	
	/**
	 * Create and return regions list.
	 * @return array
	 */
	public static function getRegionsList()
	{
		$regions = array(
			'empty_value' => '*Toutes*',
			'aquitaine' => 'Aquitaine'
		);
		return $regions;
	}
	
	/**
	 * Create and return event types list.
	 * @return array
	 */
	public static function getEventTypesList()
	{
		$eventTypes = array(
			'stage'    => 'Stage',
			'soiree'   => 'Soiree',
			'festival' => 'Festival',
			'concert'  => 'Concert'
		);
		return $eventTypes;
	}
	
	/**
	 * Create and return accommodation types list.
	 * @return array
	 */
	public static function getAccommodationTypesList()
	{
		$typesAccommodation = array(
			'hotel'    => 'Hotel',
			'particulier'   => 'Particulier',
			'colocation' => 'Colocation'
		);
		return $typesAccommodation;
	}
	
	/**
	 * Create and return towns list.
	 * @return array
	 */
	public static function getTownsList()
	{
		$villes = array(
			'Aquitaine'    => array('Bordeaux', 'Merignac', 'Pessac', 'Bègles', 'Bègles'),
		);
		return $villes;
	}
}
?>
