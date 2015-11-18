<?php

namespace AppBundle\Model;

use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\Model\Projection;
use PommProject\ModelManager\Model\ModelTrait\WriteQueries;

use PommProject\Foundation\Where;

use AppBundle\Model\AutoStructure\Config as ConfigStructure;
use AppBundle\Model\Config;

/**
 * ConfigModel
 *
 * Model class for table config.
 *
 * @see Model
 */
class ConfigModel extends Model
{
    use WriteQueries;

    /**
     * __construct()
     *
     * Model constructor
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->structure = new ConfigStructure;
        $this->flexible_entity_class = "\AppBundle\Model\Config";
    }
}
