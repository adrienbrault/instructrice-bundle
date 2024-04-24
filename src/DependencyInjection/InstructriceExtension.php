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
     *     api_keys?: array{
     *         anthropic?: string,
     *         anyscale?: string,
     *         deepinfra?: string,
     *         fireworks?: string,
     *         groq?: string,
     *         mistral?: string,
     *         ollama?: string,
     *         openai?: string,
     *         perplexity?: string,
     *         together?: string,
     *     }
     * } $mergedConfig
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $api_keys = $mergedConfig['api_keys'] ?? [];

        $container->register(InstructriceFactory::class);

        $definition = $container->register(Instructrice::class);
        $definition->setFactory(new Reference(InstructriceFactory::class));

        $definition->setArguments([
            '$apiKeys' => [
                Anthropic::class => $api_keys['anthropic'] ?? null,
                Anyscale::class => $api_keys['anyscale'] ?? null,
                DeepInfra::class => $api_keys['deepinfra'] ?? null,
                Fireworks::class => $api_keys['fireworks'] ?? null,
                Groq::class => $api_keys['groq'] ?? null,
                Mistral::class => $api_keys['mistral'] ?? null,
                Ollama::class => $api_keys['ollama'] ?? null,
                OpenAi::class => $api_keys['openai'] ?? null,
                Perplexity::class => $api_keys['perplexity'] ?? null,
                Together::class => $api_keys['together'] ?? null,
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
