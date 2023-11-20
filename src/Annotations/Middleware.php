<?php

namespace Jamkrindo\Annotations;

use Attribute;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
#[Attribute]
class Middleware
{
    public function __construct(
        public ?array $value
    ) {}
}