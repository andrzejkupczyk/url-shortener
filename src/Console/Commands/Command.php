<?php

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
        $url = Url::fromNative($this->argument('url'));

        $this->displayLink($shortener, $url);
    }

    protected function bitly(): UrlShortener
    {
        $apiKey = $this->resolveApiKey('bitly');
        $config = config('shortener.providers.bitly');

        return UrlShortener::bitly($config['api_uri'], $apiKey, $config['domain']);
    }

    protected function firebase(): UrlShortener
    {
        $config = config('shortener.providers.firebase');

        $shortener = UrlShortener::firebase(
            $config['api_uri'],
            $this->resolveApiKey('firebase'),
            $config['domain']
        );

        $dynamicLinkSuffix = $config['unguessable'] ? 'useUnguessableSuffix' : 'useShortSuffix';
        call_user_func([$shortener->provider(), $dynamicLinkSuffix]);

        return $shortener;
    }

    protected function tinyUrl(): UrlShortener
    {
        return UrlShortener::tinyUrl(
            config('shortener.providers.tinyUrl.api_uri'),
            $this->resolveApiKey('tinyUrl')
        );
    }

    protected function resolveApiKey(string $name): string
    {
        $apiKey = config("shortener.providers.{$name}.api_key");

        if (empty($apiKey)) {
            $apiKey = $this->ask(sprintf('Provide your %s API key', ucfirst($name)));
        }

        return $apiKey;
    }

    abstract protected function displayLink(UrlShortener $shortener, Url $url): void;
}
