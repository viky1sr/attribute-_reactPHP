<?php

namespace Jamkrindo\Controllers;

use Jamkrindo\Annotations\Middleware;
use Jamkrindo\Annotations\Prefix;
use Jamkrindo\Annotations\RestController;
use Jamkrindo\Annotations\RouteGet;

#[RestController(TestingController::class)]
#[Prefix("/api")]
#[Middleware(['jwt'])]
class TestingController
{
    #[RouteGet("/data-user/{id}")]
    public function getDataById(RequestBody $request,int $id) : void
    {
    }

    #[RouteGet("/data-user/genre")]
    public function get(RequestBody $request,int $id) : void
    {

    }

    #[RouteGet("/data-user")]
    public function create(RequestBody $request,int  $id) : void
    {

    }
}
