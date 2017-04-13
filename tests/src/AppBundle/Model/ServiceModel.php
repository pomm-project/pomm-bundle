<?php

namespace AppBundle\Model;

use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\Model\Projection;
use PommProject\ModelManager\Model\ModelTrait\WriteQueries;

use PommProject\Foundation\Where;

use AppBundle\Model\AutoStructure\Service as ServiceStructure;
use AppBundle\Model\Service;

use Psr\Log\LoggerInterface;

/**
 * ServiceModel
 *
 * Model class for table service.
 *
 * @see Model
 */
class ServiceModel extends Model
{
    use WriteQueries;

    /** @var LoggerInterface */
    private $logger;

    /**
     *
     * Model constructor
     *
     * @param  LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->structure = new ServiceStructure;
        $this->flexible_entity_class = "\AppBundle\Model\Service";
    }

    public function getSum()
    {
        return $this->query('SELECT 1+1 AS sum WHERE 1=1')->get(0)['sum'];
    }
}
