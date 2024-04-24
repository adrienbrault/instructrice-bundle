Symfony bundle for the [adrienbrault/instructrice][instructrice] library.

Install the bundle:
```
composer require adrienbrault/instructrice-bundle:dev-main adrienbrault/instructrice:dev-main
```

Configure api keys:
```yaml
# config/packages/instructrice.yaml
instructrice:
    anthropic:
        api_key: '%env(default::ANTHROPIC_API_KEY)'
    anyscale:
        api_key: '%env(default::ANYSCALE_API_KEY)'
    deepinfra:
        api_key: '%env(default::DEEPINFRA_API_KEY)'
    fireworks:
        api_key: '%env(default::FIREWORKS_API_KEY)'
    groq:
        api_key: '%env(default::GROQ_API_KEY)'
    mistral:
        api_key: '%env(default::MISTRAL_API_KEY)'
    ollama:
        api_key: '%env(default::OLLAMA_API_KEY)'
    openai:
        api_key: '%env(default::OPENAI_API_KEY)'
    perplexity:
        api_key: '%env(default::PERPLEXITY_API_KEY)'
    together:
        api_key: '%env(default::TOGETHER_API_KEY)'
```

Use [instructrice][instructrice]:
```php
use AdrienBrault\Instructrice\Instructrice;
use AdrienBrault\Instructrice\LLM\Provider\OpenAi;

public function controller(Instructrice $instructrice, HubInterface $hub)
{
    $sentiment = $instructrice->get(
        type: [
            'type' => 'string',
            'enum' => ['positive', 'neutral', 'negative'],
        ],
        'Pretty descent!',
        'Sentiment analysis',
        llm: OpenAi::GPT_4T,
    );
}
```

If you are using mercure to stream updates, you will want to use the `onChunk` argument:
```php
use AdrienBrault\Instructrice\Instructrice;
use AdrienBrault\Instructrice\LLM\LLMChunk;
use AdrienBrault\Instructrice\LLM\Provider\OpenAi;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

public function controller(Instructrice $instructrice, HubInterface $hub)
{
    $context = 'web page html converted to markdown';
    $context = 'email html body converted to markdown';
    // See https://github.com/thephpleague/html-to-markdown
    // And I highly suggest making sure League\HTMLToMarkdown\Converter\TableConverter is enabled!

    $products = $instructrice->getList(
        Product::class,
        $context,
        'Find all the products!',
        llm: OpenAi::GPT_4T,
        onChunk: function (array $products, LLMChunk $chunk) use ($hub) {
            $hub->publish(new Update(
                'product_123',
                $this->renderView('product.stream.html.twig', [
                    'products' => $products,
                ])
            ));
        },
    );
}
```

[instructrice]: https://github.com/adrienbrault/instructrice
