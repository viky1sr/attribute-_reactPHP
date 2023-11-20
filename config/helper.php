<?php

function get_class_attributes(object $object): array
{
    return array_reverse((new ReflectionClass($object))->getAttributes());
}

function get_method_attributes(object $object, string $method): array
{
    return array_reverse((new ReflectionMethod($object, $method))->getAttributes());
}

function attribute_exists(string $attributeClass, string $context): bool
{
    foreach (get_class_attributes($attributeClass) as $attribute) {
        if ($attribute->getContext() === $context) {
            return true;
        }
    }

    return false;
}

if (!function_exists('env')) {
    function env(string $name, string $default = ""): string
    {
        if (empty($_ENV[$name])) {
            return $default;
        }
        return $_ENV[$name];
    }
}


if (!function_exists('getConfig')) {
    function getConfig($name_file) {
        // Implementasi getConfig() di sini
    }
}
