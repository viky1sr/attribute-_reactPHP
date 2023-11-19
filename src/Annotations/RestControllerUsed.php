<?php

namespace Jamkrindo\Annotations;

use InvalidArgumentException;
use ReflectionClass;

class RestControllerUsed
{
    public static function validateRestControllerUsage(): void {
        $class = new ReflectionClass(RestController::class);
        $restControllerAttribute = $class->getAttributes(RestController::class);

        if (empty($restControllerAttribute) && !static::hasRestControllerMethod($class)) {
            throw new InvalidArgumentException(
                "The attribute can only be used with classes or methods that have RestController attribute."
            );
        }
    }

    private static function hasRestControllerMethod(ReflectionClass $class): bool {
        foreach ($class->getMethods() as $method) {
            $methodAttributes = $method->getAttributes(RestController::class);
            if (!empty($methodAttributes)) {
                return true;
            }
        }
        return false;
    }
}
