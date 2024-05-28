<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UrlShortener\StoreUrlRequest;
use App\Services\Google\SafeBrowsingService;
use App\Services\UrlShortener\UrlShortenerService;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class UrlShortenerController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private readonly SafeBrowsingService $safeBrowsingService,
        private readonly UrlShortenerService $urlShortenerService
    )
    {
    }

    public function store(StoreUrlRequest $request): JsonResponse
    {
        $url = $request->getUrl();

        try {
            $isSafe = $this->safeBrowsingService->checkIfUrlIsSafe($url);

            if (!$isSafe) {
                $this->errorResponse('The URL is not safe');
            }
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }

        $shortenedUrl = $this->urlShortenerService->generateAndStoreUrl($url);

        return $this->successResponse(['shortened_url' => $shortenedUrl], 'URL shortened successfully');
    }

}
