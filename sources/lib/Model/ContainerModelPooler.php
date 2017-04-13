<?php
/*
 * This file is part of the PommProject/PommBundle package.
 *
 * (c) 2014 - 2016 Grégoire HUBERT <hubert.greg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PommProject\PommBundle\Model;

use PommProject\ModelManager\Model\ModelPooler;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * PommExtension
 *
 * DIC extension
 *
 * @package   PommBundle
 * @copyright 2016 Grégoire HUBERT
 * @author    Miha Vrhovnik
 * @license   X11 {@link http://opensource.org/licenses/mit-license.php}
 * @see       Extension
 */
class ContainerModelPooler extends ModelPooler implements ContainerAwareInterface, ServiceMapInterface
{
    use ContainerAwareTrait;

    private $serviceMap = [];

    /**
     * {@inheritdoc}
     */
    public function addModelToServiceMapping($class, $serviceId)
    {
        $this->serviceMap[$class] = $serviceId;
    }

    /**
     * {@inheritdoc}
     */
    protected function createClient($class)
    {
        if (array_key_exists($class, $this->serviceMap)) {
            return $this->container->get($this->serviceMap[$class]);
        }

        return parent::createClient($class);
    }
}
