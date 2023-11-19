<?php

namespace Jamkrindo\Lib;

class Router
{
    public static function handle(string $method,string $uri)
    {
        $routes = require __DIR__ .'/../../bootstrap/routes_cache.php';
        $route = !empty($routes[strtoupper($method)]) ? $routes[strtoupper($method)] : [];
        $items = [];

        foreach($route as $key => $item) {
            $uriHttp = explode("/",$uri);
            $uriRoute = explode("/",$key);
            $lnMaxUri = count($uriHttp);

            if($lnMaxUri === count($uriRoute))
            {
                $http = array_filter($uriHttp);
                $route = array_filter($uriRoute);
                $checkTrue = 0;
                $isTrue = (count($http) - 1);

                if(count($http) > 2) {
                    $httpSlice2 = 'xx '.implode('',array_slice($http,1,-1));
                    $routeSlice2 = implode('',array_slice($route,1,-1));
                    if(is_int(strpos($httpSlice2,$routeSlice2))) {
                        foreach(array_keys($http) as $k) {
                            if($k !== $lnMaxUri && $route[$k] === $http[$k]) {
                                $checkTrue++;
                            }
                        }
                        if($checkTrue === $isTrue) {
                            $items[$key] = $item;
                        }
                    }
                } elseif($uri === $key) {
                    $items[$key] = $item;
                }
            }
        }

        if (!empty($items) && count($items) > 1) {
            $tampsRoute = [];
            foreach ($items as $route => $item) {
                if($route === $uri) {
                    return $item;
                }
                if(is_int(strpos($route,"{"))) {
                    $tampsRoute = $item;
                }
            }
            return $tampsRoute;
        }
        if(count($items) === 1) {
            return $items[0];
        }
        return $items;
    }

}
