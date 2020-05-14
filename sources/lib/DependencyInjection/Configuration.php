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
        $treeBuilder = new TreeBuilder('pomm');
        $rootNode = method_exists($treeBuilder, 'getRootNode') ? $treeBuilder->getRootNode() : $treeBuilder->root('pomm');

        $rootNode
            ->children()
                ->arrayNode('configuration')
                    ->useAttributeAsKey('key')
                    ->requiresAtLeastOneElement()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('dsn')->isRequired()->end()
                            ->scalarNode('class:session_builder')
                                ->defaultNull()
                                ->beforeNormalization()
                                    ->always()
                                    ->then(function ($v) {
                                        @trigger_error('class:session_builder is deprecated since version 2.3 and will be removed in 3.0. Use session_builder config key instead with a service id.', E_USER_DEPRECATED);
                                        return $v;
                                    })
                                ->end()
                            ->end()
                            ->scalarNode('session_builder')->defaultNull()->end()
                            ->scalarNode('pomm:default')->end()
                        ->end()
                        ->validate()
                            ->ifTrue(function ($v) {
                                return isset($v['session_builder']) && isset($v['class:session_builder']);
                            })
                            ->thenInvalid('You cannot use both "session_builder" and "class:session_builder" at the same time.')
                        ->end()
                        ->beforeNormalization()
                            ->always()
                            ->then(function ($v) {
                                if (!isset($v['session_builder']) && !isset($v['class:session_builder'])) {
                                    $v['session_builder'] = 'pomm.model_manager.session_builder';
                                }
                                return $v;
                            })
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
