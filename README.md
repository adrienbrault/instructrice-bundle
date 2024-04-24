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
        api_key: '%env(ANTHROPIC_API_KEY)%'
    anyscale:
        api_key: '%env(ANYSCALE_API_KEY)%'
    deepinfra:
        api_key: '%env(DEEPINFRA_API_KEY)%'
    fireworks:
        api_key: '%env(FIREWORKS_API_KEY)%'
    groq:
        api_key: '%env(GROQ_API_KEY)%'
    mistral:
        api_key: '%env(MISTRAL_API_KEY)%'
    ollama:
        api_key: '%env(OLLAMA_API_KEY)%'
    openai:
        api_key: '%env(OPENAI_API_KEY)%'
    perplexity:
        api_key: '%env(PERPLEXITY_API_KEY)%'
    together:
        api_key: '%env(TOGETHER_API_KEY)%'
```

Use [instructrice][instructrice]:
```php
use AdrienBrault\Instructrice\Instructrice;
use AdrienBrault\Instructrice\LLM\Provider\OpenAi;

public function controller(Instructrice $instructrice)
{
    $sentiment = $instructrice->get(
        type: [
            'type' => 'string',
            'enum' => ['positive', 'neutral', 'negative'],
        ],
        'Pretty descent!',
        'Sentiment analysis',
        llm: OpenAi::GPT_4T
    );
}
```

[instructrice]: https://github.com/adrienbrault/instructrice
