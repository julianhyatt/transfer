<?php
namespace Jellyfish\Transfer\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('jellyfish_transfer');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('namespace_prefix')
                    ->defaultValue('Generated')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
