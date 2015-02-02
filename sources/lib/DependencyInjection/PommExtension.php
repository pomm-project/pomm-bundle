<?php
/*
 * This file is part of the PommProject/PommBundle package.
 *
 * (c) 2014 Grégoire HUBERT <hubert.greg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PommProject\PommBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * PommExtension
 *
 * DIC extension
 *
 * @package PommBundle
 * @copyright 2014 Grégoire HUBERT
 * @author Nicolas JOSEPH
 * @license X11 {@link http://opensource.org/licenses/mit-license.php}
 * @see Extension
 */
class PommExtension extends Extension
{
    /**
     * load
     *
     * @see Extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/services'));
        $loader->load('pomm.yml');

        $config = $this->configure($configs, $container);
    }

    /**
     * configure
     *
     * Configure the DIC using configuration file.
     *
     * @access public
     * @param  array            $configs
     * @param  ContainerBuilder $container
     * @return null
     */
    public function configure(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $container->setParameter('pomm.configuration', $config['configuration']);

        $logger = $this->getLogger($config);
        if ($logger !== null) {
            $container->getDefinition('pomm')
                ->addMethodCall('setLogger', [$this->getLogger($config)]);
        }

        return $config;
    }

    /**
     * getLogger
     *
     * Return a logger reference is any.
     *
     * @access private
     * @param  array    $config
     * @return Reference|null
     */
    private function getLogger(array $config)
    {
        $logger = null;

        if (isset($config['logger']['service'])) {
            $service = $config['logger']['service'];

            if (is_string($service) && strpos($service, '@') === 0) {
                $logger = new Reference(substr($service, 1));
            }
        }
        return $logger;
    }
}
