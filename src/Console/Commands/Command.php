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
        return UrlShortener::bitly(
            $this->resolveApiKey('bitly'),
            config('shortener.providers.bitly.domain', 'bit.ly')
        );
    }

    protected function firebase(): UrlShortener
    {
        $domain = config('shortener.providers.firebase.domain');
        $mustBeUnguessable = config('shortener.providers.firebase.unguessable', true);
        $dynamicLinkSuffix = $mustBeUnguessable ? 'usingUnguessableSuffix' : 'usingShortSuffix';

        $shortener = UrlShortener::firebase($this->resolveApiKey('firebase'), $domain);
        $shortener->provider()->$dynamicLinkSuffix();

        return $shortener;
    }

    protected function personal(): UrlShortener
    {
        $connectionUrl = config('shortener.clients.database.url');
        $baseUrl = config('shortener.providers.personal.base_url');

        return UrlShortener::personal($connectionUrl, $baseUrl);
    }

    protected function tinyUrl(): UrlShortener
    {
        return UrlShortener::tinyUrl($this->resolveApiKey('tinyUrl'));
    }

    protected function resolveApiKey(string $name): string
    {
        $apiKey = config("shortener.providers.$name.api_key");

        if (empty($apiKey)) {
            $apiKey = $this->ask(sprintf('Provide your %s API key', ucfirst($name)));
        }

        return $apiKey;
    }

    abstract protected function displayLink(UrlShortener $shortener, Url $url): void;
}
