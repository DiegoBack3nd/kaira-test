<?php

namespace Tests\Feature;

use App\Services\UrlShortenerService;
use Tests\TestCase;

class ShortUrlTest extends TestCase
{
    /**
     * Verifies that a valid Bearer token is required to access the endpoint
     */
    public function test_it_requires_a_valid_bearer_token(): void
    {
        $response = $this->postJson('/api/v1/short-urls', [
            'url' => 'http://www.example.com',
        ]);

        $response->assertStatus(401); // No authorization provided
    }

    /**
     * Verifies that a valid Bearer token is accepted
     */
    public function test_it_accepts_a_valid_bearer_token(): void
    {
        $this->assertBearerToken('{}[]()', 201);
    }

    /**
     * Verifies that an invalid Bearer token is rejected.
     */
    public function test_it_rejects_an_invalid_bearer_token(): void
    {
        $this->assertBearerToken('{(})', 401);
    }


    public function test_shorten_url_success()
    {
        $service = new UrlShortenerService();
        $shortenedUrl = $service->shortenUrl('https://example.com');

        $this->assertEquals('https://tinyurl.com/peakb', $shortenedUrl);
    }

    /**
     * Helper method to send requests with a Bearer token and assert the response status.
     *
     * @param string $token
     * @param int $expectedStatus
     * @return void
     */
    private function assertBearerToken(string $token, int $expectedStatus): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/short-urls', [
                'url' => 'http://www.example.com',
            ]);

        $response->assertStatus($expectedStatus);
    }
}
