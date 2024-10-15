<?php

namespace App\Interfaces;

interface UrlShortenerServiceInterface
{
    public function shortenUrl(string $url): string;
}
