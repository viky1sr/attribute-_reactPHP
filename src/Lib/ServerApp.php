<?php

namespace Jamkrindo\Lib;

use Closure;
use Jamkrindo\Lib\App\LoggerRequest;
use Jamkrindo\Lib\App\LogMiddleware;
use Jamkrindo\Lib\App\RateLimiter;
use Jamkrindo\Lib\App\RequestBody;
use Jamkrindo\Lib\App\Router;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\HttpServer;
use React\Http\Message\Response;
use React\Promise\PromiseInterface;
use React\Socket\SocketServer;
use Throwable;

final class ServerApp
{
    public function __construct(protected $container){

    }

    private static function logMiddleware(): Closure
    {
        return static function(ServerRequestInterface $request, callable $next) {
            return LogMiddleware::log($request, $next);
        };
    }

    private static function handle($method,$uri) {
        return Router::handle($method,$uri);
    }

    private static function isRouteExist(ServerRequestInterface $request)
    {
        $method = $request->getMethod();
        $uri = $request->getUri()->getPath();
        $logMiddleware = self::logMiddleware();
        $route = self::handle($method,$uri);
        if(!empty($route)) {
            if(!empty($route['error'])) {
                return Response::plaintext($route['error']);
            }
            $newRequest = new RequestBody($request);
            if(count($route['parameter_types']) === count($route['value_path'])) {
                $params = $route['value_path'];
            } else {
                $params = array_merge([$newRequest],$route['value_path']);
            }
            $controller = new $route['controller']();
            $action = $route['action'];
            $middlewareResult =  RateLimiter::rateLimiterMiddleware(
                $request,$controller,$action,$params,$logMiddleware
            );

            if ($middlewareResult instanceof PromiseInterface) {
                return $middlewareResult;
            }
            return $middlewareResult;
        }
    }

    public static function async()
    {
        $http = new HttpServer(function (ServerRequestInterface $request){
            try {
                $response = self::isRouteExist($request);
                if($response instanceof Response) {
                    return $response;
                }
                return new Response(404,['Content-Type' => 'text/plain'],"Page not found!");
            }catch (Throwable $e) {
                LoggerRequest::logInLine($e->getMessage(),"error");
                return new Response(500, ['Content-Type' => 'text/plain'], 'Internal Server Error');

            }
        });

        $uri = env("APP_URL","127.0.0.1:8000");
        $socket = new SocketServer($uri);
        $http->listen($socket);
        echo "\033[0;32mServer running on: {$uri}\033[0m\n";
    }

    public static function sync()
    {
        echo "Belum di buat hehehehhe";die;
    }

}
