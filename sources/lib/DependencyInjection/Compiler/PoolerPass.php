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
class PoolerPass implements DI\Compiler\CompilerPassInterface
{
    public function process(DI\ContainerBuilder $container)
    {
        // find all service IDs with the appropriate tag
        $taggedServices = $container->findTaggedServiceIds('pomm.pooler');

        $poolers = [];
        foreach ($taggedServices as $id => $tags) {
            $poolers[] = new DI\Reference($id);
        }

        $definition = $container->getDefinition('pomm.session_builder.configurator');
        $definition->replaceArgument(0, $poolers);
    }
}
