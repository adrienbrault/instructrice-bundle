<?php

declare(strict_types=1);

namespace AdrienBrault\InstructriceBundle\DependencyInjection;

use AdrienBrault\Instructrice\Http\SymfonyStreamingClient;
use AdrienBrault\Instructrice\Instructrice;
use AdrienBrault\Instructrice\InstructriceFactory;
use AdrienBrault\Instructrice\LLM\LLMFactory;
use AdrienBrault\Instructrice\LLM\Provider\Anthropic;
use AdrienBrault\Instructrice\LLM\Provider\Anyscale;
use AdrienBrault\Instructrice\LLM\Provider\DeepInfra;
use AdrienBrault\Instructrice\LLM\Provider\Fireworks;
use AdrienBrault\Instructrice\LLM\Provider\Groq;
use AdrienBrault\Instructrice\LLM\Provider\Mistral;
use AdrienBrault\Instructrice\LLM\Provider\Ollama;
use AdrienBrault\Instructrice\LLM\Provider\OpenAi;
use AdrienBrault\Instructrice\LLM\Provider\Perplexity;
use AdrienBrault\Instructrice\LLM\Provider\Together;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class InstructriceExtension extends ConfigurableExtension
{
    /**
     * @param array{
     *     anthropic?: array{
     *         api_key?: string
     *     },
     *     anyscale?: array{
     *         api_key?: string
     *     },
     *     deepinfra?: array{
     *         api_key?: string
     *     },
     *     fireworks?: array{
     *         api_key?: string
     *     },
     *     groq?: array{
     *         api_key?: string
     *     },
     *     mistral?: array{
     *         api_key?: string
     *     },
     *     ollama?: array{
     *         api_key?: string
     *     },
     *     openai?: array{
     *         api_key?: string
     *     },
     *     perplexity?: array{
     *         api_key?: string
     *     },
     *     together?: array{
     *         api_key?: string
     *     },
     * } $mergedConfig
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $container->register(InstructriceFactory::class);

        $definition = $container->register(Instructrice::class);
        $definition->setFactory(new Reference(InstructriceFactory::class));

        $definition->setArguments([
            '$apiKeys' => [
                Anthropic::class => $mergedConfig['anthropic']['api_key'] ?? null,
                Anyscale::class => $mergedConfig['anyscale']['api_key'] ?? null,
                DeepInfra::class => $mergedConfig['deepinfra']['api_key'] ?? null,
                Fireworks::class => $mergedConfig['fireworks']['api_key'] ?? null,
                Groq::class => $mergedConfig['groq']['api_key'] ?? null,
                Mistral::class => $mergedConfig['mistral']['api_key'] ?? null,
                Ollama::class => $mergedConfig['ollama']['api_key'] ?? null,
                OpenAi::class => $mergedConfig['openai']['api_key'] ?? null,
                Perplexity::class => $mergedConfig['perplexity']['api_key'] ?? null,
                Together::class => $mergedConfig['together']['api_key'] ?? null,
            ],
            '$llmFactory' => new Reference(LLMFactory::class),
            '$serializer' => new Reference('serializer'),
            '$propertyInfo' => new Reference('property_info'),
        ]);

        $definition = $container->register(SymfonyStreamingClient::class);
        $definition->setArguments([
            '$logger' => new Reference('logger'),
            '$client' => new Reference('http_client'),
        ]);

        $definition = $container->register(LLMFactory::class);
        $definition->setArguments([
            '$client' => new Reference(SymfonyStreamingClient::class),
            '$logger' => new Reference('logger'),
        ]);

        $container->setAlias('instructrice', Instructrice::class);
        $container->setAlias('instructrice.llm_factory', LLMFactory::class);
    }
}
