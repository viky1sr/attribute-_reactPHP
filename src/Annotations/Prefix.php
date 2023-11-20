<?php

namespace Jamkrindo\Annotations;

use Attribute;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
#[Attribute]
class Prefix
{
    public function __construct(public ?string $value)
    {}
}
