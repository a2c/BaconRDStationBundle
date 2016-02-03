<?php

namespace Bacon\Bundle\RDStationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('bacon_rd_station');

        $rootNode
            ->children()
                ->arrayNode('api')
                    ->children()
                        ->scalarNode('base_url')->defaultValue('https://www.rdstation.com.br/api/')->end()
                        ->scalarNode('version')->defaultValue('1.3')->end()
                        ->scalarNode('private_token')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('token')->isRequired()->cannotBeEmpty()->end()
                    ->end()
                ->isRequired(true)
            ->end()
        ->end()
        ;

        return $treeBuilder;
    }
}
