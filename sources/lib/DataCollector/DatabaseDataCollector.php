<?php
/*
 * This file is part of Pomm's SymfonyBundle package.
 *
 * (c) 2014 Grégoire HUBERT <hubert.greg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PommProject\PommBundle\DataCollector;

use PommProject\SymfonyBridge\DatabaseDataCollector as BaseDatabaseDataCollector;
use Symfony\Component\EventDispatcher\Event;

/**
 * Data collector for the database profiler.
 *
 * @package PommSymfonyBridge
 * @copyright 2014 Grégoire HUBERT
 * @author Jérôme MACIAS
 * @author Grégoire HUBERT
 * @license X11 {@link http://opensource.org/licenses/mit-license.php}
 * @see DataCollector
 */
class DatabaseDataCollector extends BaseDatabaseDataCollector
{
    public function onKernelController(Event $event)
    {
        return;
    }
}
