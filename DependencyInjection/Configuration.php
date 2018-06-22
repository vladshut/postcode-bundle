<?php


namespace PostcodeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 *
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('postcode');

        $rootNode->children()
            ->arrayNode('api')->isRequired()->children()
                ->scalarNode('key')->isRequired()->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
