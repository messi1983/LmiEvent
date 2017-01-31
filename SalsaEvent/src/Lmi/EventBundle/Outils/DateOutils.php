<?php
namespace Lmi\EventBundle\Outils;
use Lmi\EventBundle\Constants\Constants;
use Lmi\EventBundle\Entity\Date;

/**
 * Dates utils class
 */
class  DateOutils
{	
	
	/**
	 * Constructor
	 */
	private function __construct()
	{
	}
	
	/**
	 * Create Max DateTime from a given dateTime.
	 * @param \DateTime $date
	 * @return Max DateTime from a given dateTime
	 */
	public static function createMaxDateTime($date) 
	{
		$dateDebutMaxInStr = $date->format(Constants::DEFAULT_DATE_FORMAT);
		return \DateTime::createFromFormat(Constants::DATE_TIME_FORMAT, $dateDebutMaxInStr.' 23:59:59');
	}
	
	/**
	 * Create Min DateTime from a given dateTime.
	 * @param \DateTime $date
	 * @return Min DateTime from a given dateTime
	 */
	public static function createMinDateTime($date)
	{
		$dateDebutMaxInStr = $date->format(Constants::DEFAULT_DATE_FORMAT);
		return \DateTime::createFromFormat(Constants::DATE_TIME_FORMAT, $dateDebutMaxInStr.' 00:00:00');
	}
	
	/**
	 * replace old dates By the current date
	 * @param array $listDates
	 */
	public static function replaceOldDatesByCurrentDate($listDates)
	{
		$today = new Date();
		$today->setDate(date(Constants::DEFAULT_DATE_FORMAT));
	
		$finalResult = array();
		$todayAdded = false;
	
		// all date < today are considered as today
		foreach ($listDates as $date) {
			if($date->getDate() <= $today->getDate()) {
				if(!$todayAdded) {
					array_push($finalResult, $today);
					$todayAdded = true;
				}
			} else {
				array_push($finalResult, $date);
			}
		}
		return $finalResult;
	}
}
?>
