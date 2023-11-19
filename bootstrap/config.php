<?php

use Jamkrindo\Annotations\Middleware;
use Jamkrindo\Annotations\Prefix;
use Jamkrindo\Annotations\RestController;
use Jamkrindo\Annotations\RouteDelete;
use Jamkrindo\Annotations\RouteGet;
use Jamkrindo\Annotations\RoutePost;
use Jamkrindo\Annotations\RoutePut;
return [
    RestController::class => DI\autowire(RestController::class),
    Middleware::class => DI\autowire(Middleware::class),
    Prefix::class => DI\autowire(Prefix::class),
    RouteGet::class => DI\autowire(RouteGet::class),
    RoutePost::class => DI\autowire(RoutePost::class),
    RoutePut::class => DI\autowire(RoutePut::class),
    RouteDelete::class => DI\autowire(RouteDelete::class),
];
