<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessTokenMiddleware
{
    /**
     * Handle an incoming request
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');

        // Check if the Authorization header is present and is valid
        if (!$authHeader || !$this->isValidBearerToken($authHeader)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }

    /**
     * Validates the Bearer Token format
     *
     * @param string $authHeader
     * @return bool
     */
    private function isValidBearerToken(string $authHeader): bool
    {
        // Check if the authorization has the format "Bearer <token>" and take it.
        // The regular expression allows the token to be empty
        if (preg_match('/^Bearer\s*(.*)$/', $authHeader, $matches)) {
            $token = $matches[1];

            // Empty token is also valid
            return $token === '' || $this->isValidParentheses($token);
        }

        return false;
    }

    /**
     * Checks if the parenthesis string is valid.
     *
     * (The key to this problem is to know that the last character to open is the first to close)
     * @param string $string
     * @return bool
     */
    private function isValidParentheses(string $string): bool
    {
        $stack = [];

        // It associates each closing character with its opening character
        $mapping = [
            ')' => '(',
            '}' => '{',
            ']' => '[',
        ];

        foreach (str_split($string) as $char) {
            // If the character is a closure, checks the last open
            if (array_key_exists($char, $mapping)) {
                if (empty($stack) || array_pop($stack) !== $mapping[$char]) {
                    return false;
                }
            } else {
                // If it is an opening, it stacks
                $stack[] = $char;
            }
        }

        // If the stack is empty, all parentheses are balanced
        return empty($stack);
    }
}
