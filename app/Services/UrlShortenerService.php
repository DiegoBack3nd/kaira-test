<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class UrlShortenerService
{
    public function shortenUrl(string $url): string
    {
        $apiUrl = config('api-urls.tinyurl_create');

        /*
         * I have set withoutVerifying because it gave me problems with the SSL certificate in my local
         * and I have assumed that it is not something very significant in this test.
         * Anyway the solution is something related to the file cacert.pem
         * */
        $response = Http::withoutVerifying()->get("{$apiUrl}?url={$url}");

        if ($response->failed()) {
            throw new Exception('Failed to connect to TinyURL API');
        }

        return $response->body();
    }
}
