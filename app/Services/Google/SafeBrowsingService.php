<?php

namespace App\Services\Google;

use App\Services\CurlService;
use Exception;

class SafeBrowsingService
{
    public function __construct(private readonly CurlService $curlService)
    {
    }

    /**
     * @throws Exception
     */
    public function checkIfUrlIsSafe(string $url): bool
    {
        try {
            $response = $this->curlService->get(
                'https://safebrowsing.googleapis.com/v4/threatMatches:find?key=' . config('google.key'),
                $url
            );
            $result = json_decode($response, true);
            if (isset($result['error'])) {
                throw new Exception($result['error']['message']);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return empty($result);
    }
}