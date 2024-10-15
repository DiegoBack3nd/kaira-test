<?php

namespace App\Services;

class TokenValidationService
{
    /**
     * Validates the Bearer Token format
     *
     * @param string $authHeader
     * @return bool
     */
    public function isValidBearerToken(string $authHeader): bool
    {
        if (preg_match('/^Bearer\s*(.*)$/', $authHeader, $matches)) {
            $token = $matches[1];
            return $token === '' || $this->isValidParentheses($token);
        }

        return false;
    }

    /**
     * Checks if the parenthesis string is valid.
     *
     * @param string $string
     * @return bool
     */
    private function isValidParentheses(string $string): bool
    {
        $stack = [];
        $mapping = [
            ')' => '(',
            '}' => '{',
            ']' => '[',
        ];

        // Iterate over each character in the input string and check if the character is a closing parenthesis
        foreach (str_split($string) as $char) {
            if (array_key_exists($char, $mapping)) {
                // If the stack is empty or the last opened parenthesis doesn't match the current closing one return false
                if (empty($stack) || array_pop($stack) !== $mapping[$char]) {
                    return false;
                }
            } else {
                // If it's an opening parenthesis, push it onto the stack
                $stack[] = $char;
            }
        }

        // If the stack is empty after processing all characters the parentheses are balanced, return true
        return empty($stack);
    }
}
