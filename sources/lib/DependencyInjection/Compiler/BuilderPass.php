<?php

namespace PommProject\PommBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class BuilderPass.
 *
 * @author Manuel Raynaud <manu@periodable.com>
 */
class BuilderPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $config = $container->getParameter('pomm.configuration');

        $definition = $container->getDefinition('pomm');

        foreach ($config as $name => $pommConfig) {
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
    }
}
