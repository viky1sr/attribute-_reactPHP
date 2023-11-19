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
    protected ?string $classInUse = null;

    public function __construct(public ?string $value)
    {}
}
