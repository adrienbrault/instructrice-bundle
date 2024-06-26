Symfony bundle for the [adrienbrault/instructrice][instructrice] library.

Install the bundle:
```
composer require adrienbrault/instructrice-bundle:@dev adrienbrault/instructrice:@dev
```

Configure api keys:
```yaml
# config/packages/instructrice.yaml
instructrice:
    default: '%env(string:INSTRUCTRICE_DSN)%'
    #default: Ollama::HERMES2THETA_LLAMA3_8B
    anthropic:
        api_key: '%env(string:default::ANTHROPIC_API_KEY)%'
    anyscale:
        api_key: '%env(string:default::ANYSCALE_API_KEY)%'
    deepinfra:
        api_key: '%env(string:default::DEEPINFRA_API_KEY)%'
    fireworks:
        api_key: '%env(string:default::FIREWORKS_API_KEY)%'
    groq:
        api_key: '%env(string:default::GROQ_API_KEY)%'
    google:
        api_key: '%env(string:default::GEMINI_API_KEY)%'
    mistral:
        api_key: '%env(string:default::MISTRAL_API_KEY)%'
    ollama:
        api_key: '%env(string:default::OLLAMA_API_KEY)%'
    openai:
        api_key: '%env(string:default::OPENAI_API_KEY)%'
    perplexity:
        api_key: '%env(string:default::PERPLEXITY_API_KEY)%'
    together:
        api_key: '%env(string:default::TOGETHER_API_KEY)%'
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

You can use Mercure to update your frontend while the LLM is completing JSON, using the `onChunk` callback:
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
            // FYI: $chunk->propertyPath
            // You could leverage that to only update each property once in the UI, instead of streaming every single character

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
