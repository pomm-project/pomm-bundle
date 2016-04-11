<?php
/*
 * This file is part of Pomm's SymfonyBundle package.
 *
 * (c) 2016 Grégoire HUBERT <hubert.greg@gmail.com>
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
 * @package PommSymfonyBridge
 * @copyright 2016 Grégoire HUBERT
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
            $pomm->addPostConfiguration($name, function($session) use ($callable) {
                $session
                    ->getClientUsingPooler('listener', 'query')
                    ->attachAction($callable)
                ;
            });
        }
    }
}