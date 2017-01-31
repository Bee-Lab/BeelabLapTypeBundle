<?php

namespace Beelab\LapTypeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('beelab_user');

        $rootNode
            ->children()
                ->scalarNode('lap_form_type')
                    ->cannotBeEmpty()
                    ->defaultValue('Beelab\LapTypeBundle\Form\Type\LapType')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
