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