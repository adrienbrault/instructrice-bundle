<?php

declare(strict_types=1);

namespace AdrienBrault\InstructriceBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('instructrice');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('anthropic')
                    ->children()
                        ->scalarNode('api_key')->end()
                    ->end()
                ->end()
                ->arrayNode('anyscale')
                    ->children()
                        ->scalarNode('api_key')->end()
                    ->end()
                ->end()
                ->arrayNode('deepinfra')
                    ->children()
                        ->scalarNode('api_key')->end()
                    ->end()
                ->end()
                ->arrayNode('fireworks')
                    ->children()
                        ->scalarNode('api_key')->end()
                    ->end()
                ->end()
                ->arrayNode('groq')
                    ->children()
                        ->scalarNode('api_key')->end()
                    ->end()
                ->end()
                ->arrayNode('google')
                    ->children()
                        ->scalarNode('api_key')->end()
                    ->end()
                ->end()
                ->arrayNode('mistral')
                    ->children()
                        ->scalarNode('api_key')->end()
                    ->end()
                ->end()
                ->arrayNode('ollama')
                    ->children()
                        ->scalarNode('api_key')->end()
                    ->end()
                ->end()
                ->arrayNode('openai')
                    ->children()
                        ->scalarNode('api_key')->end()
                    ->end()
                ->end()
                ->arrayNode('perplexity')
                    ->children()
                        ->scalarNode('api_key')->end()
                    ->end()
                ->end()
                ->arrayNode('together')
                    ->children()
                        ->scalarNode('api_key')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
