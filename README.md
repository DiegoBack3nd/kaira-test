# URL Shortener API

This project provides a simple API to shorten URLs using Laravel 11 and the TinyURL service.

## Requirements

- PHP 8.2 or higher
- Composer
- Laravel 11

## Installation

1. Clone the repository:
   ```bash
   git clone https://your-repository-url.git
   cd your-repository

2. Install dependencies:
    ```bash
   composer install

3. Set up environment variables:

    ```bash
   cp .env.example .env
   
4. Generate application key:
    ```bash
   php artisan key:generate

## API Endpoints

- **POST `/api/v1/short-urls`**: Shorten a URL.
    - **Requires**: A valid Bearer token in the Authorization header.
    - **Request Body**:
      ```json
      {
        "url": "http://www.example.com"
      }
      ```
    - **Response**:
        - **201 Created**:
          ```json
          {
            "url": "https://tinyurl.com/shortened-url"
          }
          ```
        - **401 Unauthorized**:
          ```json
          {
            "error": "Unauthorized"
          }
          ```
        - **500 Internal Server Error**:
          ```json
          {
            "error": "Failed to shorten URL: error message"
          }
          ```

## Testing

To run the test suite, use:

    php artisan test

## Debugging

Xdebug is configured for local development. Ensure it is installed and enabled in your `php.ini` file


