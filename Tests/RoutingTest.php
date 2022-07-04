<?php

use Clarity\Request\Request;
use Clarity\Request\RequestInterface;
use Clarity\Route\Route;
use Clarity\Router\Router;
use PHPUnit\Framework\TestCase;

final class RoutingTest extends TestCase
{
    public function testBasicRouting()
    {
        // Test the path
        $mostBasicRoute = Route::new("/someRoute", function(){});
        $this->assertTrue($mostBasicRoute->matchRequest(Request::new("GET", "/someRoute")));
        $this->assertFalse($mostBasicRoute->matchRequest(Request::new("GET", "/anotherRoute")));

        $aboutGet = Request::new("GET", "/about");
        $aboutPost = Request::new("POST", "/about");

        // This route should work with any method
        $anyMethodRoute = Route::new("/about", function(){});
        $this->assertTrue($anyMethodRoute->matchRequest($aboutGet));
        $this->assertTrue($anyMethodRoute->matchRequest($aboutPost));

        // This route should work only with the GET and POST methods
        $anyMethodRoute = Route::new("/about", function(){}, methods:["GET", "POST"]);
        $this->assertTrue($anyMethodRoute->matchRequest($aboutGet));
        $this->assertTrue($anyMethodRoute->matchRequest($aboutPost));

        // This route should work only with the GET method
        $anyMethodRoute = Route::new("/about", function(){}, methods:"GET");
        $this->assertTrue($anyMethodRoute->matchRequest($aboutGet));
        $this->assertFalse($anyMethodRoute->matchRequest($aboutPost));
    }

    public function testParameters()
    {
        Router::callRouteCallback(
            Route::new("/about", function($req){
                $this->assertInstanceOf(RequestInterface::class, $req);
            }),
            Request::new("GET", "/about")
        );

        Router::callRouteCallback(
            Route::new("/about", function(RequestInterface $req){
                $this->assertEquals("bar", $req->params("foo"));
            }),
            Request::new("GET", "/about", ["foo"=>"bar"])
        );
    }

    public function testSlugs()
    {
        Router::callRouteCallback(
            Route::new("/article/{articleId}", function($_, int $articleId){
                $this->assertEquals(2098, $articleId);
            }),
            Request::new("GET", "/article/2098")
        );

        Router::callRouteCallback(
            Route::new("/article/{articleId}", function(RequestInterface $req){
                $this->assertEquals(2098, $req->getSlug("articleId"));
            }),
            Request::new("GET", "/article/2098")
        );
    }
}