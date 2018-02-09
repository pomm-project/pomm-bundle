<?php

namespace AppBundle\DependencyInjection;

use \Symfony\Component\Config\FileLocator;
use \Symfony\Component\DependencyInjection\ContainerBuilder;
use \Symfony\Component\HttpKernel\DependencyInjection\Extension;
use \Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class AppExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if (version_compare(\Symfony\Component\HttpKernel\Kernel::VERSION, '3.3', '>=')) {
            $loader->load('services_sf33.yml');
        }
    }
}
