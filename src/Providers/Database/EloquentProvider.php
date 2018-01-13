<?php

namespace WebGarden\UrlShortener\Providers\Database;

use Illuminate\Database\Query\Builder;
use WebGarden\Model\ValueObject\Number\Natural as Id;
use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\Factories\LinkFactory;
use WebGarden\UrlShortener\Model\Factories\ShortCodeFactory;
use WebGarden\UrlShortener\Model\Factories\ShortCodeGenerator;
use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\Providers\Provider;

class EloquentProvider implements Provider
{
    /** @var Url */
    private $baseUrl;

    /** @var ShortCodeGenerator|string */
    private $shortCodeFactory;

    /** @var Builder */
    private $query;

    public function __construct(Url $baseUrl, Builder $query, string $shortCodeFactory = ShortCodeFactory::class)
    {
        if (!is_subclass_of($shortCodeFactory, ShortCodeGenerator::class)) {
            throw new \InvalidArgumentException('Invalid short code factory class given.');
        }

        $this->baseUrl = $baseUrl;
        $this->shortCodeFactory = $shortCodeFactory;
        $this->query = $query;
    }

    public function expand(Url $shortUrl): Link
    {
        /** @var \stdClass|null $row */
        if (!$row = $this->query->where('short_url', $shortUrl)->first()) {
            throw new \InvalidArgumentException("URL \"$shortUrl\" could not be found.");
        }

        return LinkFactory::createFromRow($row);
    }

    public function shorten(Url $longUrl): Link
    {
        $row = $this->query->where('long_url', $longUrl)->first() ?: $this->store($longUrl);

        if ($row === null) {
            throw new \InvalidArgumentException("URL \"$longUrl\" could not be shortened.");
        }

        return LinkFactory::createFromRow($row);
    }

    /**
     * @param  Url $longUrl
     *
     * @return object|null
     */
    protected function store(Url $longUrl)
    {
        try {
            return $this->query->connection->transaction($this->storeClosure($longUrl));
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function generateShortUrl(Id $id): Url
    {
        return Url::fromNative(sprintf('%s/%s', $this->baseUrl, $this->shortCodeFactory::createFromId($id)));
    }

    private function storeClosure(Url $longUrl): \Closure
    {
        return function () use ($longUrl) {
            $id = $this->query->insertGetId(['long_url' => $longUrl]);
            $record = [
                'id' => $id,
                'short_url' => $this->generateShortUrl(Id::fromNative($id)),
                'long_url' => $longUrl,
            ];

            $this->query->where('id', $id)->update($record);

            return (object) $record;
        };
    }
}
