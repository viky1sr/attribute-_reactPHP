<?php

namespace Jamkrindo\Annotations;

use Attribute;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
#[Attribute]
class RoutePut
{
    public function __construct(
        protected string $uri
    ) {
        RestControllerUsed::validateRestControllerUsage();
    }
}