<?php

namespace App\Http\Middleware;

use App\Services\TokenValidationService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessTokenMiddleware
{
    private TokenValidationService $tokenValidationService;

    public function __construct(TokenValidationService $tokenValidationService)
    {
        $this->tokenValidationService = $tokenValidationService;
    }

    /**
     * Handle an incoming request
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');

        // Check if the Authorization header is present and is valid
        if (!$authHeader || !$this->tokenValidationService->isValidBearerToken($authHeader)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
