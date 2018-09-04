<?php
/*
 * This file is part of the PommProject/PommBundle package.
 *
 * (c) 2018 Grégoire HUBERT <hubert.greg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PommProject\PommBundle;

use PommProject\Foundation\Exception\SqlException;
use PommProject\Foundation\Listener\Listener;
use PommProject\Foundation\Session\Session;

use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

/**
 * Data collector for the database profiler.
 *
 * @package PommBundle
 * @copyright 2018 Grégoire HUBERT
 * @author Jérôme MACIAS
 * @author Grégoire HUBERT
 * @license X11 {@link http://opensource.org/licenses/mit-license.php}
 * @see DataCollector
 */
class DatabaseDataCollector extends DataCollector
{
    /** @var Stopwatch */
    private $stopwatch;

    public function __construct($unused = null, Stopwatch $stopwatch = null)
    {
        if ($unused !== null) {
            trigger_error("The parameter Pomm has been deleted for to delete the high dependency.", E_USER_DEPRECATED);
        }

        $this->stopwatch = $stopwatch;
        $this->data = [
            'time' => 0,
            'queries' => [],
            'exception' => null,
        ];
    }

    /**
     * @param string $name
     * @param array $data
     * @param $session
     *
     * @return null
     */
    public function execute($name, $data, Session $session)
    {
        switch ($name) {
            case 'query:post':
                $this->data['time'] += $data['time_ms'];
                $data += array_pop($this->data['queries']);
                /* fall-through */
            case 'query:pre':
                $this->data['queries'][] = $data;
                break;
        }

        $this->watch($name);
    }

    private function watch($name)
    {
        if ($this->stopwatch !== null) {
            switch ($name) {
                case 'query:pre':
                    $this->stopwatch->start('query.pomm', 'pomm');
                    break;
                case 'query:post':
                    $this->stopwatch->stop('query.pomm');
                    break;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        if ($exception instanceof SqlException) {
            $this->data['exception'] = $exception->getMessage();
        }
    }

    /**
     * Return the list of queries sent.
     *
     * @return array
     */
    public function getQueries()
    {
        return $this->data['queries'];
    }

    /**
     * Return the number of queries sent.
     *
     * @return integer
     */
    public function getQuerycount()
    {
        return count($this->data['queries']);
    }

    /**
     * Return queries total time.
     *
     * @return float
     */
    public function getTime()
    {
        return $this->data['time'];
    }

    /**
     * Return sql exception.
     *
     * @return \PommProject\Foundation\Exception\SqlException|null
     */
    public function getException()
    {
        return $this->data['exception'];
    }

    /**
     * Return profiler identifier.
     *
     * @return string
     */
    public function getName()
    {
        return 'pomm';
    }

    /**
     * {@inheritdoc}
     */
    public function reset()
    {
        $this->stopwatch->reset();
        $this->data = array();
    }
}
