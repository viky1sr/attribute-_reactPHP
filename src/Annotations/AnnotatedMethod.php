<?php

namespace Jamkrindo\Annotations;

use ReflectionMethod;

class AnnotatedMethod
{
    /**
     * @throws \ReflectionException
     */
    public static function getAnnotatedMethod($object, string $uri): ?ReflectionMethod
    {
        $class = new \ReflectionClass($object);
        $methodName = self::getMethodNameFromUri($uri);

        return $class->hasMethod($methodName) ? $class->getMethod($methodName) : null;
    }

    private static function getMethodNameFromUri(string $uri): string
    {
        $parts = explode('/', trim($uri, '/'));
        $methodName = '';
        foreach ($parts as $part) {
            $methodName .= ucfirst($part);
        }

        return lcfirst($methodName);
    }
}
