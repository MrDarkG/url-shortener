<?php

namespace App\Models;

use App\QueryBuilders\UrlsQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $url
 * @property string $hash
 *
 * @method static UrlsQueryBuilder query()
 */
class Urls extends Model
{
    use HasFactory;

    public function newEloquentBuilder($query): UrlsQueryBuilder
    {
        return new UrlsQueryBuilder($query);
    }

    protected $fillable = [
        'url',
        'hash',
    ];

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function setHash(string $hash): void
    {
        $this->hash = $hash;
    }
}
