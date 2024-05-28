<?php

namespace App\Services\UrlShortener;

use App\Http\Resources\ShortenedUrls;
use App\Models\Urls;

class UrlShortenerService
{
    public function generateShortenedUrl(string $url): string
    {
        $hash = substr(md5($url.time()), 0, 6);

        if (!$this->checkIfHashIsUnique($hash)) {
            return $hash;
        }
        return $this->generateShortenedUrl($url);
    }

    public function checkIfHashIsUnique(string $hash): bool
    {
        return Urls::query()->whereHash($hash)->exists();
    }

    public function generateAndStoreUrl(string $url): ShortenedUrls
    {
        $urlExists = $this->getUrlBy($url);

        if ($urlExists) {
            return $urlExists;
        }

        $hash = $this->generateShortenedUrl($url);

        $urls = new Urls();
        $urls->setUrl($url);
        $urls->setHash($hash);
        $urls->save();

        return new ShortenedUrls($urls);
    }

    public function getUrlBy(string $url): ?ShortenedUrls
    {
        $url = Urls::query()->whereUrl($url)->first();

        if (!$url) {
            return null;
        }

        return new ShortenedUrls($url);
    }

    public function getUrlByHash(string $hash): ?ShortenedUrls
    {
        $url = Urls::query()->whereHash($hash)->first();
        if (!$url) {
            return null;
        }
        return new ShortenedUrls($url);
    }

}