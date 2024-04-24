Symfony bundle for the [adrienbrault/instructrice](https://github.com/adrienbrault/instructrice) library.

Install the bundle:
```
composer require adrienbrault/instructrice-bundle@dev adrienbrault/instructrice@dev
```

Configure api keys:
```yaml
instructrice:
    api_keys:
        anthropic: '%env(ANTHROPIC_API_KEY)'
        anyscale: '%env(ANYSCALE_API_KEY)'
        deepinfra: '%env(DEEPINFRA_API_KEY)'
        fireworks: '%env(FIREWORKS_API_KEY)'
        groq: '%env(GROQ_API_KEY)'
        mistral: '%env(MISTRAL_API_KEY)'
        ollama: '%env(OLLAMA_API_KEY)'
        openai: '%env(OPENAI_API_KEY)'
        perplexity: '%env(PERPLEXITY_API_KEY)'
        together: '%env(TOGETHER_API_KEY)'
```

Use instructrice:
```
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
