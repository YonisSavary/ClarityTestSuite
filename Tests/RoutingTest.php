<?php

use Clarity\Request\Request;
use Clarity\Route\Route;
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
}