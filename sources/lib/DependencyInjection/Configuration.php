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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration
 *
 * Configuration manager.
 *
 * @package PommBundle
 * @copyright 2014 Grégoire HUBERT
 * @author Nicolas JOSEPH
 * @license X11 {@link http://opensource.org/licenses/mit-license.php}
 * @see ConfigurationInterface
 */
class Configuration implements ConfigurationInterface
{
    /**
     * getConfigTreeBuilder
     *
     * @see ConfigurationInterface
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('pomm');
        $rootNode
            ->children()
                ->arrayNode('configuration')
                    ->useAttributeAsKey('key')
                    ->requiresAtLeastOneElement()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('dsn')->isRequired()->end()
                            ->scalarNode('class:session_builder')->end()
                            ->scalarNode('pomm:default')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('logger')
                    ->children()
                        ->scalarNode('service')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
