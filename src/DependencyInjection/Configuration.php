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
                ->arrayNode('api_keys')
                    ->children()
                        ->scalarNode('anthropic')->end()
                        ->scalarNode('anyscale')->end()
                        ->scalarNode('deepinfra')->end()
                        ->scalarNode('fireworks')->end()
                        ->scalarNode('groq')->end()
                        ->scalarNode('mistral')->end()
                        ->scalarNode('ollama')->end()
                        ->scalarNode('openai')->end()
                        ->scalarNode('perplexity')->end()
                        ->scalarNode('together')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
