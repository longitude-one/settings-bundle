<?php

namespace LongitudeOne\SettingsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('settings');
//        $rootNode = $treeBuilder->getRootNode();
//
//        $rootNode
//            ->children()
//                ->scalarNode('table_name')->defaultValue('lo_settings')->end()
//            ->end()
//        ;

        return $treeBuilder;
    }
}