<?php

namespace Jamkrindo\Lib\App;

class Router
{
    public static function handle(string $method,string $uri)
    {
        $routes = require __DIR__ .'/../../../bootstrap/routes_cache.php';
        $route = !empty($routes[strtoupper($method)]) ? $routes[strtoupper($method)] : [];
        $items = [];
        $errors = [];

        foreach($route as $key => $item) {
            $uriFunction = $key;
            $uriHttp = explode("/",$uri);
            $uriRoute = explode("/",$key);
            $lnMaxUri = count($uriHttp);

            if($lnMaxUri === count($uriRoute))
            {
                $http = array_filter($uriHttp);
                $route = array_filter($uriRoute);
                $maxCheck = 0;
                $maxRegex = $item['max_regex'];
                $maxValidation = count($http) - $maxRegex;
                $params = [];
                foreach($http as $k => $value) {
                    if(!preg_match('/^\{.+\}$/', $route[$k]) && ($value === $route[$k])) {
                        $maxCheck++;
                    } else {
                        $field = str_replace(['{','}'],'',$route[$k]);
                        if(!empty($item['parameter_types'][$field])) {
                            if($item['parameter_types'][$field] === 'int') {
                                if(!is_numeric($value)){
                                    $error = "Parameter must be int, variable \${$field} type: {$item['parameter_types'][$field]}, uri: {$uriFunction}";
                                    $errors[$key] = $error;
                                } else {
                                    $params[] = (int)$value;
                                }
                            } elseif ($item['parameter_types'][$field] === gettype($value) && !is_numeric($value)) {
                                $params[] = $value;
                            }
                        }
                    }
                }

                if($maxValidation === $maxCheck && count($params) == $maxRegex) {
                    $items[$key] = array_merge(
                        $item,
                        ['value_path' => $params]
                    );
                }
            }
        }


        if (!empty($items)) {
            $maxRoute = count($items);
            foreach ($items as $key => $item){
                if(!empty($errors[$key]) && $maxRoute === 1){
                    return [
                        'error' => $errors[$key]
                    ];
                }
                if(empty($errors[$key])){
                    return $item;
                }
            }
        }
    }
}
