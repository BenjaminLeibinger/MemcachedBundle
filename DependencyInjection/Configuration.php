<?php
/**
 * User: 'Benjamin Leibinger'
 * Date: 01.11.2016 19:36
 */

namespace Isl\MemcachedBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('isl_memcached');

        $rootNode->append($this->getPools());

        return $treeBuilder;
    }

    private function getPools()
    {
        $tree = new TreeBuilder();
        $node = $tree->root('pools');
        $node
            ->requiresAtLeastOneElement()
            ->useAttributeAsKey('name')
            ->prototype('array')
                ->children()
                    ->arrayNode('servers')
                        ->requiresAtLeastOneElement()
                        ->prototype('array')
                            ->children()
                                ->scalarNode('host')
                                    ->cannotBeEmpty()
                                    ->isRequired()
                                ->end()
                                ->scalarNode('port')
                                    ->defaultValue(11211)
                                    ->validate()
                                    ->ifTrue(function ($v) { return !is_numeric($v); })
                                        ->thenInvalid('port must be numeric')
                                    ->end()
                                ->end()
                                ->scalarNode('weight')
                                    ->defaultValue(1)
                                    ->validate()
                                    ->ifTrue(function ($v) { return !is_numeric($v); })
                                        ->thenInvalid('weight must be numeric')
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();
        return $node;
    }

}