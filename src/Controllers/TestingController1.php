<?php

namespace Jamkrindo\Controllers;

use Jamkrindo\Annotations\Middleware;
use Jamkrindo\Annotations\Prefix;
use Jamkrindo\Annotations\RestController;
use Jamkrindo\Annotations\RouteGet;
use Jamkrindo\Lib\App\RequestBody;
use React\Http\Message\Response;

#[RestController(TestingController1::class)]
#[Prefix("/api/test1")]
#[Middleware(['jwt'])]
class TestingController1
{
    #[RouteGet("/data-user/{id}")]
    public function getDataById(RequestBody $request,int $id) : Response
    {
        return Response::json([
            'message' => 'Success',
            'data' => $request->getBodyArray()
        ]);
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
