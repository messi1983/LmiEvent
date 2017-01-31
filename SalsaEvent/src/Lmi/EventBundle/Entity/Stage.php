<?php

namespace Lmi\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stage
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Stage extends CommonStageSoiree
{
    /**
     * @var string
     *
     * @ORM\Column(name="danse", type="string", length=25)
     */
    private $danse;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Set danse
     *
     * @param string $danse
     * @return Stage
     */
    public function setDanse($danse)
    {
        $this->danse = $danse;
    
        return $this;
    }

    /**
     * Get danse
     *
     * @return string 
     */
    public function getDanse()
    {
        return $this->danse;
    }
}
