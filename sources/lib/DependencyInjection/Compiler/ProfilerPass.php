<?php

namespace PommProject\PommBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection as DI;

class ProfilerPass implements DI\Compiler\CompilerPassInterface
{
    public function process(DI\ContainerBuilder $container)
    {
        if ($container->hasDefinition('profiler') === false) {
            return;
        }

        $definition = new DI\Definition("PommProject\\PommBundle\\Controller\\PommProfilerController", [
            new DI\Reference('router'),
            new DI\Reference('profiler'),
            new DI\Reference('twig'),
            new DI\Reference('pomm')
        ]);
        $definition->setPublic(true);
        $container->setDefinition('pomm.controller.profiler', $definition);

        $definition = new DI\Definition(
            "PommProject\\PommBundle\\Twig\\Extension\\ProfilerExtension",
            [new DI\Reference('twig.loader.filesystem')]
        );
        //we run after the twig tags are collected so we need to manually do what twig compiler pass does
        $twig = $container->getDefinition('twig');
        $twig->addMethodCall('addExtension', [new DI\Reference('pomm.twig_extension')]);

        $container->setDefinition('pomm.twig_extension', $definition);
    }
}
