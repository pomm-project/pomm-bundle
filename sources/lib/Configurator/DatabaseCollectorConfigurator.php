<?php
/*
 * This file is part of the PommProject/PommBundle package.
 *
 * (c) 2018 Grégoire HUBERT <hubert.greg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PommProject\PommBundle\Configurator;

use PommProject\Foundation\Pomm;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

/**
 * Data collector for the database profiler.
 *
 * @package PommBundle
 * @copyright 2018 Grégoire HUBERT
 * @author Paris Mikael
 * @license X11 {@link http://opensource.org/licenses/mit-license.php}
 * @see DataCollector
 */
class DatabaseCollectorConfigurator
{
    protected $datacollector;

    public function __construct(DataCollector $datacollector)
    {
        $this->datacollector = $datacollector;
    }

    /**
     * @param Pomm $pomm
     *
     * @return null
     */
    public function configure(Pomm $pomm)
    {
        $callable = [$this->datacollector, 'execute'];

        foreach ($pomm->getSessionBuilders() as $name => $builder) {
            $pomm->addPostConfiguration($name, function ($session) use ($callable) {
                $session
                    ->getClientUsingPooler('listener', 'query')
                    ->attachAction($callable)
                ;
            });
        }
    }
}
