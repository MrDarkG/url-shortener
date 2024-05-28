<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $url
 * @property string $hash
 * @property Carbon $created_at
 */
class ShortenedUrls extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'url' => $this->url,
            'hash' => $this->hash,
            'shortened_url' => route('redirect', ['hash' => $this->hash]),
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
        ];
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function getShortenedUrl(): string
    {
        return url('/' . $this->hash);
    }
}
