<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortUrlRequest;
use App\Services\UrlShortenerService;
use Illuminate\Http\JsonResponse;

class ShortUrlController extends Controller
{
    private UrlShortenerService $urlShortenerService;

    public function __construct(UrlShortenerService $urlShortenerService)
    {
        $this->urlShortenerService = $urlShortenerService;
    }

    /**
     * Generates a shortened URL and returns it as a JSON response.
     *
     * @param ShortUrlRequest $request
     * @return JsonResponse
     */
    public function generateShortUrl(ShortUrlRequest $request): JsonResponse
    {
        try {
            $shortUrl = $this->urlShortenerService->shortenUrl($request->get('url'));
            return response()->json(['url' => $shortUrl], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to shorten URL: ' . $e->getMessage()], 500);
        }
    }
}
