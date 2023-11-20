<?php

namespace Jamkrindo\Lib\App;

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

class RateLimiter
{
    public function __construct(){
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }

    public static function checkRateLimit(string $ip): bool
    {
        $limit = 100;
        $cache = new FileCache();

        $key = 'rate_limit:' . $ip;
        $checkData = $cache->get($key);
        if ($checkData !== null && $checkData < $limit) {
            $cache->set($key, $checkData + 1, 60 * 60);
            return true;
        }
        if ($checkData === null) {
            $cache->set($key, 1, 60 * 60 );
            return true;
        }

        return false;
    }

    public static function rateLimiterMiddleware(
        ServerRequestInterface $request, $controller, $method, $reqMapping, $logMiddleware
    ) : Response
    {
        $ip = !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : $request->getServerParams()['REMOTE_ADDR'];
        if (self::checkRateLimit($ip)) {
            $response = call_user_func_array([$controller, $method], $reqMapping);
            return $logMiddleware($request, function () use ($response) {
                return $response;
            });
        }
        error_log("Rate limit check failed");
        return new Response(429, ['Content-Type' => 'text/plain'], 'Rate limit exceeded');
    }

}
