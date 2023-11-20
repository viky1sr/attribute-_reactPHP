<?php

namespace Jamkrindo\Lib\Formater;

class FormaterCLI
{
    protected const BLUE = "\033[0;34m";
    protected const RED = "\033[41m";
    protected const RESET = "\033[0m";

    protected static function repeat(): void
    {
        echo str_repeat(
                '+-----------------'.
                '+--------------------------------'.
                '+----------------------'.
                '+----------------------------------------+',
                1
            ) . "\n";
    }


    public static function printFormattedArrayRouter(array $routes)
    {
        printf("%s%-15s %-30s %-20s %-40s%s\n", static::BLUE, 'Method', 'URI', 'Action', 'Controller', static::RESET);
        self::repeat();
        foreach ($routes as $array) {
            printf("%s%-15s %-30s %-20s %-40s%s\n",
                static::RED,
                $array['method'],
                $array['uri'],
                $array['action'],
                $array['controller'],
                static::RESET
            );
            self::repeat();
        }

    }
}
