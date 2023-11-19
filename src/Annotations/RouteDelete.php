<?php

namespace Jamkrindo\Annotations;

use Attribute;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
#[Attribute]
class RouteDelete
{
    public function __construct(
        protected string $uri
    ) {
        RestControllerUsed::validateRestControllerUsage();
    }
}