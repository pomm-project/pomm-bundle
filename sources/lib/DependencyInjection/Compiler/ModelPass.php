<?php
/*
 * This file is part of the PommProject/PommBundle package.
 *
 * (c) 2014 - 2016 Grégoire HUBERT <hubert.greg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PommProject\PommBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection as DI;

/**
 * Class PoolerPass
 * @package PommProject\PommBundle\DependencyInjection\Compiler
 * @author  Miha Vrhovnik
 */
class ModelPass implements DI\Compiler\CompilerPassInterface
{
    public function process(DI\ContainerBuilder $container)
    {
        $this->addTagged($container, 'pomm.model', 'pomm.pooler.model', 'getModel');

        $this->addTagged($container, 'pomm.model_layer', 'pomm.pooler.model_layer', 'getModelLayer');
    }

    private function addTagged(DI\ContainerBuilder $container, $tag, $defaultServiceId, $method)
    {
        /** @var DI\Definition[] $definitions */
        $definitions = [];

        // find all service IDs with the appropriate tag
        $taggedServices = $container->findTaggedServiceIds($tag);

        foreach ($taggedServices as $id => $tags) {
            $class = $container->getDefinition($id)
                ->getClass()
            ;

            $serviceId = isset($tags[0]['pooler']) ? $tags[0]['pooler'] : $defaultServiceId;
            $sessionId = isset($tags[0]['session']) ? $tags[0]['session'] : 'pomm.default_session';

            if (!array_key_exists($serviceId, $definitions)) {
                if ($container->hasDefinition($serviceId)) {
                    $definitions[$serviceId] = $container->getDefinition($serviceId);

                    $interface = 'PommProject\PommBundle\Model\ServiceMapInterface';
                    if (!in_array($interface, class_implements($definitions[$serviceId]->getClass()), true)) {
                        throw new \RuntimeException(sprintf('Your pooler should implement %s.', $interface));
                    }
                } else {
                    throw new \RuntimeException(sprintf('There is no pooler service with id %s.', $serviceId));
                }
            }

            $definitions[$serviceId]->addMethodCall('addModelToServiceMapping', [$class, $id . '.pomm.inner']);

            $old = $container->getDefinition($id);
            $old->setPublic(true);
            $container->removeDefinition($id);
            $container->addDefinitions([$id . '.pomm.inner' => $old]);

            $service = $container->register($id, $old->getClass())
                ->setFactory([new DI\Reference($sessionId), $method])
                ->addArgument($old->getClass())
            ;

            if (version_compare(\Symfony\Component\HttpKernel\Kernel::VERSION, '3.3', '<')) {
                $container->addAutowiringType($old->getClass());
            }

            $container->setAlias($class,  $id);

        }
    }
}
