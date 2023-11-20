<?php

use DI\ContainerBuilder;
use Jamkrindo\Annotations\Middleware;
use Jamkrindo\Annotations\Prefix;
use Jamkrindo\Annotations\RestController;
use Jamkrindo\Annotations\RouteDelete;
use Jamkrindo\Annotations\RouteGet;
use Jamkrindo\Annotations\RoutePost;
use Jamkrindo\Annotations\RoutePut;
use Jamkrindo\Controllers\TestingController;
use Jamkrindo\Lib\ConfigLoaderProvider;
use Jamkrindo\Lib\ConfigRouter;

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
ConfigLoaderProvider::load(__DIR__."/../config");
$dotenv->load();

try {
    $controllerAnnotations = [];
    $containerBuilder = new ContainerBuilder;
    $containerBuilder->useAutowiring(true);
    $containerBuilder->useAttributes(true);
    $containerBuilder->addDefinitions(__DIR__ . '/config.php');
    $controllersPath = __DIR__ . '/../src/Controllers';
    $controllerAnnotations = [];

    foreach (glob($controllersPath . '/*.php') as $controllerFile)  {
        $controllerClassName = pathinfo($controllerFile, PATHINFO_FILENAME);
        $controllerClass  = "\Jamkrindo\\Controllers\\".$controllerClassName;
        if (class_exists($controllerClass)) {
            $controllerAnnotations[$controllerClass] = $controllerClass;
            $containerBuilder->addDefinitions([
                $controllerClassName => DI\autowire($controllerClass),
            ]);
        }
    }

    $containerBuilder->addDefinitions([
        ConfigRouter::class => DI\autowire(ConfigRouter::class)
            ->constructorParameter('classControllers',$controllerAnnotations),
    ]);

    return $containerBuilder->build();
}catch (Exception $e) {
    return $e->getMessage();
}
