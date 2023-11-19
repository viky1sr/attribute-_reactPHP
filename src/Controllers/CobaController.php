<?php
declare(strict_types=1);
namespace Jamkrindo\Controllers;

use Jamkrindo\Annotations\Middleware;
use Jamkrindo\Annotations\Prefix;
use Jamkrindo\Annotations\RestController;
use Jamkrindo\Annotations\RouteGet;
use Jamkrindo\Annotations\RoutePost;
use Psr\Http\Message\ServerRequestInterface;

#[RestController(CobaController::class)]
#[Prefix("/api1")]
//#[Middleware(['jwt'])]
class CobaController
{
    #[RouteGet("/data-user/{id}")]
    public function getDataByIds(ServerRequestInterface $request,int $id) : string
    {
        return "123";
    }

    #[RouteGet("/data-user/user")]
    public function getData(RequestBody $request) : String
    {
        return "123";
    }

    #[RouteGet("/data-user/mahasiswa")]
    public function getDataMahasiswa(RequestBody $request) : String
    {
        return "123";
    }

    #[RoutePost("/data-user/{id}")]
    public function update(RequestBody $request,int $id) : String
    {
        return "123";
    }

    #[RouteGet("/data-user/{id}/{name}")]
    public function testConfilt(RequestBody $request,int $id) : void
    {

    }

    #[RouteGet("/data-user")]
    public function create(RequestBody $request,int $id) : void
    {

    }
}
