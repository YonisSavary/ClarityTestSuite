<?php

use Clarity\Hooks\Hooks;
use PHPUnit\Framework\TestCase;

final class HooksTest extends TestCase
{
    public function testHook()
    {
        Hooks::on("customMessage", function(){$this->assertTrue(true);});
        Hooks::send("customMessage");

        Hooks::on("anotherEvent", function($message){$this->assertEquals("hello", $message);});
        Hooks::send("anotherEvent", "hello");
    }
}