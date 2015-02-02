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

        $definition = new DI\Definition(
            "PommProject\\SymfonyBridge\\Controller\\PommProfilerController",
            [new DI\Reference('router'), new DI\Reference('profiler'), new DI\Reference('twig'), new DI\Reference('pomm')]
        );
        $container->setDefinition('pomm.controller.profiler', $definition);
    }
}
