<?php

namespace Jamkrindo\Annotations;

use Attribute;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
#[Attribute]
class RoutePost
{
    public function __construct(
        protected string $uri
    ){}

    public function getNameUri() : array
    {
        return [
            'method' => 'POST',
            'uri' => $this->uri,
            'action' => '',
        ];
    }
}
