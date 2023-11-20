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
        protected ?string $uri = null
    ) {}

    public function getNameUri() : array
    {
        return [
            'method' => 'PUT',
            'uri' => $this->uri,
            'action' => '',
        ];
    }
}