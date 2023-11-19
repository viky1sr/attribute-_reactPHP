<?php

namespace Jamkrindo;

use Jamkrindo\Middleware\JwtMiddleware;

class Kernel
{
    protected const LOAD = [

    ];

    protected const middlewareAliases = [
        JwtMiddleware::class,
    ];


    /**
     * Get the classes to be loaded.
     *
     * @return array
     */
    public static function getLoadedClasses(): array
    {
        return static::LOAD;
    }

    public static function getMiddlewareAliases() : array
    {
        return static::middlewareAliases;
    }
}
