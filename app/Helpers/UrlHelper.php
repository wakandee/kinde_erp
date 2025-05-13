<?php
namespace App\Helpers;

class UrlHelper
{
    public static function getBaseUrl(): string
    {
        $config = require __DIR__ . '/../../config/config.php';
        return rtrim($config['base_url'] ?? '/', '/') . '/';
    }

    public static function getCurrentTab(): string
    {
        $baseUrl = self::getBaseUrl();
        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';

        $path = trim(parse_url($requestUri, PHP_URL_PATH), '/');
        $basePath = trim(parse_url($baseUrl, PHP_URL_PATH), '/');

        if ($basePath && strpos($path, $basePath) === 0) {
            $path = substr($path, strlen($basePath));
        }

        $segments = explode('/', trim($path, '/'));
        return $segments[0] ?? '';
    }
}
