<?php

use Clarity\Pipe\Pipe;
use Clarity\Request\Request;
use Clarity\Request\RequestInterface;
use Clarity\Response\ResponseInterface;
use Clarity\Route\Route;
use Clarity\Router\Router;
use PHPUnit\Framework\TestCase;

final class PipeTest extends TestCase
{
    public function testPipe()
    {
        $myPipe = Pipe::new([
            fn(RequestInterface $req) => $req->getSlug("number"),
            fn($number) => $number * 5,
            fn($number) => $number - 2
        ]);

        $myRoute = Route::new("/process/{number}", $myPipe);

        $res = Router::callRouteCallback($myRoute, Request::new("GET", "/process/5"));

        $this->assertInstanceOf(ResponseInterface::class, $res);
        $this->assertEquals(23, $res->getContent());
        $this->assertEquals("23", $res->getContent());
    }
}