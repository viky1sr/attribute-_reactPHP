<?php

use Jamkrindo\Lib\ConfigRouter;
use Jamkrindo\Lib\Router;
use Psr\Http\Message\ServerRequestInterface;

$container = require __DIR__ . '/../bootstrap/app.php';
$configRouter  = $container->get(ConfigRouter::class);

$http = new React\Http\HttpServer(function (ServerRequestInterface $request) use($container)
{
    $method = $request->getMethod();
    $uri = $request->getUri()->getPath();
    $route = Router::handle($method,$uri);
    if(!empty($route)) {
       if(is_int(strpos($route['uri'],"{"))){
           $toArr = explode("/", $uri);
           $controller = new $route['controller']();
           $action = $route['action'];
           return $controller->$action($request, end($toArr));
       }
       return new $route['controller']->$route['action']($request);
    }
    return React\Http\Message\Response::plaintext(
        "Page not found!"
    );
});

$socket = new React\Socket\SocketServer('127.0.0.1:3000');
$http->listen($socket);

echo "Server running at http://127.0.0.1:3000" . PHP_EOL;

//$stringA = "/api/testing/book";
//
//$stringB2 = "/api/b2";
//
//$stringB3 = "/api/testing/{id}";
//
//$stringB3A = "/api/test/book";
//
//$stringB4 = "/api/testing/update/{id}";
//
//jadi untuk pencari A harus sama dengan string B yang mana ?
//    maka logicnya cari yang ada 3 parameter uri ,
//    di pilih $stringB3 dan $stringB3A.
//
//    dari $stringB3 dan $stringB3A di samakan setiap 2 parameter uri ke StringA
// pilih yang ke 2 nya sama = maka yang sama adalah $stringB3 , di karenakan ( /api/tesitng ) sama seperti punaynya $stringA