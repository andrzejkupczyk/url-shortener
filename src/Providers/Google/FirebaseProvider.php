<?php

namespace WebGarden\UrlShortener\Providers\Google;

use GuzzleHttp\ClientInterface;
use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\Factories\LinkFactory;
use WebGarden\UrlShortener\Model\ValueObjects\Domain;
use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\Providers\HttpProvider;

/**
 * The Firebase Dynamic Links provider.
 *
 * @see https://firebase.google.com/docs/dynamic-links/rest
 */
class FirebaseProvider extends HttpProvider
{
    const SHORT_SUFFIX = 'SHORT';
    const UNGUESSABLE_SUFFIX = 'UNGUESSABLE';

    protected $baseUri = 'https://firebasedynamiclinks.googleapis.com/v1/shortLinks';

    /** @var \WebGarden\UrlShortener\Model\ValueObjects\Domain */
    protected $dynamicLinkDomain;

    /** @var string Specifies how the path component of the short Dynamic Link is generated. */
    protected $suffixLength = self::UNGUESSABLE_SUFFIX;

    protected static function normalizeResponse($stream): array
    {
        $decoded = parent::normalizeResponse($stream);

        return [
            'id' => 0,
            'short_url' => $decoded->shortLink,
            'long_url' => $decoded->previewLink,
        ];
    }

    public function __construct(string $apiKey, Domain $dynamicLinkDomain, ClientInterface $client = null)
    {
        parent::__construct($apiKey, $client);

        $this->dynamicLinkDomain = $dynamicLinkDomain;
    }

    public function expand(Url $shortUrl): Link
    {
        throw new \BadMethodCallException(
            'The Firebase does not provide an API which allows to expand shortened URLs.'
        );
    }

    public function shorten(Url $longUrl): Link
    {
        $row = $this->post([
            'json' => [
                'dynamicLinkInfo' => [
                    'dynamicLinkDomain' => $this->dynamicLinkDomain->toNative(),
                    'link' => $longUrl->toNative(),
                ],
                'suffix' => [
                    'option' => $this->suffixLength,
                ],
            ],
            'query' => [
                'key' => $this->apiKey,
            ],
        ]);

        return LinkFactory::createFromRow($row);
    }

    /**
     * Return suffix that is being used.
     *
     * @return string
     */
    public function suffixBeingUsed(): string
    {
        return $this->suffixLength;
    }

    /**
     * Specify that suffix must be short.
     *
     * @return self
     */
    public function usingShortSuffix()
    {
        $this->suffixLength = self::SHORT_SUFFIX;

        return $this;
    }

    /**
     * Specify that suffix must be unguessable.
     *
     * @return self
     */
    public function usingUnguessableSuffix()
    {
        $this->suffixLength = self::UNGUESSABLE_SUFFIX;

        return $this;
    }
}