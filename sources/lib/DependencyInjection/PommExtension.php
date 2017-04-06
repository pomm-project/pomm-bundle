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
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\Definition;
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
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services/pomm.yml');

        $loader->load('services/profiler.yml');

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

        $definition = $container->getDefinition('pomm');
        foreach ($config['configuration'] as $name => $pommConfig) {
            if (isset($pommConfig['session_builder'])) {
                $service = $container->getDefinition($pommConfig['session_builder']);
                $service->setArguments([$pommConfig]);

                $definition->addMethodCall('addBuilder', [$name, new Reference($pommConfig['session_builder'])]);
            } else {
                $service = uniqid($pommConfig['class:session_builder'], true);
                $cbDefinition = $container->register($service, ltrim($pommConfig['class:session_builder'], '\\'));
                $cbDefinition->setShared(false);
                $cbDefinition->setArguments([$pommConfig]);

                $definition->addMethodCall('addBuilder', [$name, new Reference($service)]);
            }

            if (isset($pommConfig['pomm:default']) && $pommConfig['pomm:default']) {
                $definition->addMethodCall('setDefaultBuilder', [$name]);

                $container->setAlias('pomm.default_session', sprintf('pomm.session.%s', $name));
            }

            //register all session's into the container
            $session = new Definition('PommProject\Foundation\Session\Session');
            $session->setFactory([new Reference('pomm'), 'getSession'])
                ->addArgument($name)
                ;
            $container->addDefinitions([sprintf('pomm.session.%s', $name) => $session]);
        }

        $logger = $this->getLogger($config);
        if ($logger !== null) {
            $definition
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
