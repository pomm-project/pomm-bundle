<?php

namespace PommProject\PommBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class PommExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $this->configure($configs, $container);
    }

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
    }

    private function getLogger($config)
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
