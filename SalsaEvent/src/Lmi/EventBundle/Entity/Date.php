<?php

namespace Lmi\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lmi\EventBundle\Constants\Constants;

/**
 * Date
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Lmi\EventBundle\Entity\DateRepository")
 * 
 * @ORM\NamedNativeQueries({
 *      @ORM\NamedNativeQuery(
 *          name             = "eventsDates_1",
 *          resultSetMapping = "mappingDates",
 *          query            = "SELECT DISTINCT DATE_FORMAT(p.dateDebut, '%Y-%m-%d') as dt FROM periode p WHERE p.dateFin >= CURRENT_DATE() AND ((EXISTS (SELECT sr.dates_id FROM soiree sr WHERE sr.dates_id = p.id AND sr.publication = :published)) OR (EXISTS (SELECT st.dates_id FROM stage st WHERE st.dates_id = p.id AND st.publication = :published))) ORDER BY dt ASC LIMIT :limit"
 *      ),
 *      @ORM\NamedNativeQuery(
 *          name             = "eventsDates_2",
 *          resultSetMapping = "mappingDates",
 *          query            = "SELECT DISTINCT DATE_FORMAT(p.dateDebut, '%Y-%m-%d') AS dt FROM periode p WHERE p.dateFin >= CURRENT_DATE() AND p.dateDebut <= :dateTimeMax AND ((EXISTS (SELECT sr.dates_id FROM soiree sr WHERE sr.dates_id = p.id AND sr.publication = :published)) OR (EXISTS (SELECT st.dates_id FROM stage st WHERE st.dates_id = p.id AND st.publication = :published))) ORDER BY dt ASC"
 *      ),
 *      @ORM\NamedNativeQuery(
 *          name             = "eventsDates_3",
 *          resultSetMapping = "mappingDates",
 *          query            = "SELECT DISTINCT DATE_FORMAT(p.dateDebut, '%Y-%m-%d') AS dt FROM periode p WHERE p.dateFin >= CURRENT_DATE() AND p.dateDebut BETWEEN :dateTimeMin AND :dateTimeMax AND ((EXISTS (SELECT sr.dates_id FROM soiree sr WHERE sr.dates_id = p.id AND sr.publication = :published)) OR (EXISTS (SELECT st.dates_id FROM stage st WHERE st.dates_id = p.id AND st.publication = :published))) ORDER BY dt ASC"
 
 *      ),
 *      @ORM\NamedNativeQuery(
 *          name             = "accommodationsDates_1",
 *          resultSetMapping = "mappingDates",
 *          query            = "SELECT DISTINCT DATE_FORMAT(p.dateDebut, '%Y-%m-%d') as dt FROM periode p INNER JOIN accommodation a ON a.periode_id = p.id WHERE p.dateFin >= CURRENT_DATE() AND a.publication = :published ORDER BY dt ASC LIMIT :limit"
 *      ),
 *      @ORM\NamedNativeQuery(
 *          name             = "accommodationsDates_2",
 *          resultSetMapping = "mappingDates",
 *          query            = "SELECT DISTINCT DATE_FORMAT(p.dateDebut, '%Y-%m-%d') as dt FROM periode p INNER JOIN accommodation a ON a.periode_id = p.id INNER JOIN event_accommodation ea ON ea.event_id = :eventId WHERE p.dateFin >= CURRENT_DATE() AND a.publication = :published AND ea.accommodation_id = a.id ORDER BY dt ASC LIMIT :limit"
 *      ),
 *      @ORM\NamedNativeQuery(
 *          name             = "carPoolingsDates_1",
 *          resultSetMapping = "mappingDates",
 *          query            = "SELECT DISTINCT DATE_FORMAT(c.dateDepart, '%Y-%m-%d') as dt FROM carpooling c WHERE c.dateDepart >= CURRENT_DATE() AND c.publication = :published ORDER BY dt ASC LIMIT :limit"
 *      ),
 *      @ORM\NamedNativeQuery(
 *          name             = "carPoolingsDates_2",
 *          resultSetMapping = "mappingDates",
 *          query            = "SELECT DISTINCT DATE_FORMAT(c.dateDepart, '%Y-%m-%d') as dt FROM carpooling c WHERE c.dateDepart >= CURRENT_DATE() AND c.publication = :published AND c.event_id = :eventId ORDER BY dt ASC LIMIT :limit"
 *      ),
 * })
 * @ORM\SqlResultSetMappings({
 *      @ORM\SqlResultSetMapping(
 *          name    = "mappingDates",
 *          entities= {
 *              @ORM\EntityResult(
 *                  entityClass = "__CLASS__",
 *                  fields      = {
 *                      @ORM\FieldResult(name = "date", column="dt"),
 *                  }
 *              )
 *          }
 *      )
 * })
 */
class Date
{
    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string")
     * @ORM\Id
     */
    private $date;
    
    /**
     * Set date
     *
     * @param string $date
     * @return string
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \Date
     */
    public function getDate()
    {
        return $this->date;
    }
}
