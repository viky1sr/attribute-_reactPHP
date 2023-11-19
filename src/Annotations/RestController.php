<?php

namespace Jamkrindo\Annotations;

use Attribute;
use InvalidArgumentException;
use ReflectionClass;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class RestController
{
    public function __construct(public ?string $value = null){
        $this->isValueNull();
        $classAttributes = (new ReflectionClass($this->value))->getAttributes();
        if($classAttributes[0]->getName() !== __CLASS__) {
            throw new InvalidArgumentException(
                "The attribute can only be used with classes or methods that have RestController attribute."
            );
        }
    }

    private function  isValueNull () : void
    {
        if(is_null($this->value)) {
            $redBold = "\033[1;31m";
            $reset = "\033[0m";
            throw new InvalidArgumentException(
                "{$redBold}The value cannot be null. Provide the Class. for example: ExampleController::class{$reset}"
            );
        }
    }

}
