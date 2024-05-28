<?php

namespace App\Http\Controllers;

use App\Services\UrlShortener\UrlShortenerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class UrlShortenerController extends Controller
{
    public function __construct(
        private readonly UrlShortenerService $urlShortenerService
    )
    {
    }

    public function redirect(string $hash): RedirectResponse
    {
        $url = $this->urlShortenerService->getUrlByHash($hash);

        if (!$url) {
            return redirect()->route('home');
        }

        return Redirect::to($url->getUrl());
    }
}
