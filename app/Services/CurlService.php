<?php

namespace App\Services;

class CurlService
{
    public function get(string $url, string $urlToCheck): bool|string
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode([
                'client' => [
                    'clientId' => config('google.client_id'),
                    'clientVersion' => '1.5.2',
                ],
                'threatInfo' => [
                    'threatTypes' => ['MALWARE', 'SOCIAL_ENGINEERING'],
                    'platformTypes' => ['WINDOWS'],
                    'threatEntryTypes' => ['URL'],
                    'threatEntries' => [
                        ['url' => $urlToCheck],
                    ],
                ],
            ])
        );
        return curl_exec($curl);
    }
}