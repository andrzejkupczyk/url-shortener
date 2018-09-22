<?php

namespace WebGarden\UrlShortener\Console\Commands;

use Illuminate\Support\Facades\DB;
use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\UrlShortener;

abstract class Command extends \Illuminate\Console\Command
{
    /** @var array */
    protected $availableProviders = ['firebase', 'google', 'eloquent', 'tinyUrl'];

    public function handle()
    {
        $provider = $this->choice('What provider would you like to use?', $this->providers(), 0);

        /** @var UrlShortener $shortener */
        $shortener = call_user_func([$this, $provider]);
        $url = Url::fromNative($this->argument('url'));

        $this->displayLink($shortener, $url);
    }

    public function providers(): array
    {
        return $this->availableProviders;
    }

    protected function eloquent(): UrlShortener
    {
        $connection = config('shortener.providers.eloquent.connection', 'mysql');
        $builder = DB::connection($connection)->table(config('shortener.providers.eloquent.table', 'links'));

        $baseUrl = config('shortener.providers.eloquent.base_url');

        if (empty($baseUrl)) {
            $baseUrl = $this->ask('Provide base URL for your shortened URLs');
        }

        return UrlShortener::{__FUNCTION__}(Url::fromNative($baseUrl), $builder);
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

    protected function google(): UrlShortener
    {
        return $this->httpProvider(__FUNCTION__);
    }

    protected function tinyUrl(): UrlShortener
    {
        return $this->httpProvider(__FUNCTION__);
    }

    protected function httpProvider(string $name): UrlShortener
    {
        return UrlShortener::$name($this->resolveApiKey($name));
    }

    protected function resolveApiKey(string $name)
    {
        $apiKey = config("shortener.providers.$name.api_key");

        if (empty($apiKey)) {
            $apiKey = $this->ask(sprintf('Provide your %s API key', ucfirst($name)));
        }

        return $apiKey;
    }

    abstract protected function displayLink(UrlShortener $shortener, Url $url);
}
