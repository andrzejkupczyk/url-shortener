<?php

declare(strict_types=1);

namespace WebGarden\UrlShortener\Providers\Google;

use BadMethodCallException;
use GuzzleHttp\RequestOptions;
use WebGarden\UrlShortener\Clients\Http\HttpClient;
use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\Factories\LinkFactory;
use WebGarden\UrlShortener\Model\ValueObjects\Domain;
use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\Providers\Provider;

/**
 * The Firebase Dynamic Links provider.
 *
 * @see https://firebase.google.com/docs/dynamic-links/rest
 */
class FirebaseProvider implements Provider
{
    public const SHORT_SUFFIX = 'SHORT';
    public const UNGUESSABLE_SUFFIX = 'UNGUESSABLE';

    /** @var HttpClient */
    protected $client;

    /** @var string */
    protected $apiKey;

    /** @var \WebGarden\UrlShortener\Model\ValueObjects\Domain */
    protected $dynamicLinkDomain;

    /** @var string Specifies how the path component of the short Dynamic Link is generated */
    protected $suffixLength = self::UNGUESSABLE_SUFFIX;

    public function __construct(HttpClient $client, string $apiKey, Domain $dynamicLinkDomain)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
        $this->dynamicLinkDomain = $dynamicLinkDomain;
    }

    public function expand(Url $shortUrl): Link
    {
        throw new BadMethodCallException(
            'The Firebase does not provide an API which allows to expand shortened URLs.'
        );
    }

    public function shorten(Url $longUrl): Link
    {
        $options = [
            RequestOptions::JSON => [
                'dynamicLinkInfo' => [
                    'dynamicLinkDomain' => (string) $this->dynamicLinkDomain,
                    'link' => (string) $longUrl,
                ],
                'suffix' => [
                    'option' => $this->suffixLength,
                ],
            ],
            RequestOptions::QUERY => [
                'key' => $this->apiKey,
            ],
        ];

        $response = $this->client->request('shortLinks', $options);

        return LinkFactory::create('', $response['shortLink'], $response['previewLink']);
    }

    /**
     * Return suffix that is being used.
     */
    public function suffixBeingUsed(): string
    {
        return $this->suffixLength;
    }

    /**
     * Specify that suffix must be short.
     */
    public function useShortSuffix(): void
    {
        $this->suffixLength = self::SHORT_SUFFIX;
    }

    /**
     * Specify that suffix must be unguessable.
     */
    public function useUnguessableSuffix(): void
    {
        $this->suffixLength = self::UNGUESSABLE_SUFFIX;
    }
}
