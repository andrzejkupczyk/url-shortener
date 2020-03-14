<?php

declare(strict_types=1);

namespace WebGarden\UrlShortener\Console\Commands;

use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\Providers\Factory;
use WebGarden\UrlShortener\UrlShortener;

abstract class Command extends \Illuminate\Console\Command
{
    public static function providers(): array
    {
        return get_class_methods(Factory::class);
    }

    public function handle()
    {
        $provider = $this->choice('What provider would you like to use?', static::providers(), 0);

        /** @var UrlShortener $shortener */
        $shortener = call_user_func([$this, $provider]);
        $url = new Url($this->argument('url'));

        $this->displayLink($shortener, $url);
    }

    protected function bitly(): UrlShortener
    {
        return UrlShortener::bitly(
            config('shortener.providers.bitly.api_uri', 'https://api-ssl.bitly.com/v4/'),
            $this->resolveApiKey('bitly'),
            config('shortener.providers.bitly.domain')
        );
    }

    protected function firebase(): UrlShortener
    {
        $shortener = UrlShortener::firebase(
            config('shortener.providers.firebase.api_uri', 'https://firebasedynamiclinks.googleapis.com/v1/'),
            $this->resolveApiKey('firebase'),
            config('shortener.providers.firebase.domain')
        );

        /** @var \WebGarden\UrlShortener\Providers\Google\FirebaseProvider $provider */
        $provider = $shortener->provider();

        if (config('shortener.providers.firebase.unguessable', true)) {
            $provider->useUnguessableSuffix();
        } else {
            $provider->useShortSuffix();
        }

        return $shortener;
    }

    protected function tinyUrl(): UrlShortener
    {
        return UrlShortener::tinyUrl(
            config('shortener.providers.tinyUrl.api_uri', 'http://tiny-url.info/api/v1/'),
            $this->resolveApiKey('tinyUrl')
        );
    }

    /**
     * @SuppressWarnings(PHPMD.ExitExpression)
     */
    protected function resolveApiKey(string $name): string
    {
        $apiKey = config("shortener.providers.{$name}.api_key");

        if (empty($apiKey)) {
            $apiKey = $this->secret(sprintf('Provide your %s API key', ucfirst($name)));
        }

        if ($apiKey === null) {
            $this->error('The API key is required');
            exit(1);
        }

        return $apiKey;
    }

    abstract protected function displayLink(UrlShortener $shortener, Url $url): void;
}
