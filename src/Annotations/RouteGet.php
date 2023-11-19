<?php

namespace Jamkrindo\Annotations;

use Attribute;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
#[Attribute]
class RouteGet
{
    public function __construct(
        public ?string $uri = null
    ) {}

    /**
     * @throws \ReflectionException
     */
    public function getNameUri() : array
    {
        return [
            'method' => 'GET',
            'uri' => $this->uri,
            'action' => '',
        ];
    }
}
