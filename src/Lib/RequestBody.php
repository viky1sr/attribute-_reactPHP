<?php

namespace Jamkrindo\Lib;

use Psr\Http\Message\ServerRequestInterface;

class RequestBody
{

    public function __construct(protected ServerRequestInterface $request){

    }

    public static function requestAble($fillable)
    {

    }
}