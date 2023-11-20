<?php

namespace Jamkrindo\Lib\App;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class LogMiddleware
{
    public static function log(ServerRequestInterface $request, callable $next)
    {
        $start = microtime(true);
        $ip = !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : $request->getServerParams()['REMOTE_ADDR'];
        $method = $request->getMethod();
        $uri = $request->getUri()->__toString();
        $date = date('Y-m-d H:i:s');
        $data = $request->getBody()->__toString();

        try {
            $response = $next($request);

            $end = microtime(true);
            $timeTaken = round(($end - $start) * 1000, 2);

            if(env("APP_RUN","async") === 'async') {
                echo "\033[0;32m[$date] Response: {$response->getStatusCode()} ".
                    "{$response->getReasonPhrase()} ($timeTaken ms)\033[0m\n";
            }

            LoggerRequest::logInLine("[$date] Request: $method $uri from $ip");

            LoggerRequest::logFormatJson([
                'date' => $date,
                'ip' => $ip,
                'method' => $method,
                'uri' => $uri,
                'data' => $data,
                'time_taken' => $timeTaken
            ]);

            return $response;
        } catch (Throwable $e) {
            echo "\n\033[0;31mError in middleware: {$e->getMessage()}\033[0m\n";
            LoggerRequest::logInLine("\033[0;31mError in middleware: {$e->getMessage()}\033[0m",'error');
            LoggerRequest::logFormatJson([
                'date' => $date,
                'ip' => $ip,
                'method' => $method,
                'uri' => $uri,
                'data' => $data,
            ],'error');
            throw new InvalidArgumentException($e->getMessage());
        }
    }
}
