<?php

use Clarity\Database\Database;
use PHPUnit\Framework\TestCase;

final class DatabaseTest extends TestCase
{
    /**
     * @dataProvider buildProvider
     */
    public function testBuild(string $query, array $params=[], string $result)
    {
        $this->assertSame($result, Database::build($query, $params));
    }

    public function buildProvider()
    {
        return [
            ["SELECT '{}'", [1.39], "SELECT '1.39'"],
            ["SELECT {}", ["One quote character shouldn't break the system"], "SELECT 'One quote character shouldn\\'t break the system'"],
            ["SELECT {}", ["Two quote characters ' shouldn't break the system"], "SELECT 'Two quote characters \\' shouldn\\'t break the system'"],
            ["SELECT {}", ["You can also spam them '''"], "SELECT 'You can also spam them \\'\\'\\''"],
            ["SELECT foo = {}", ["foo"]     , "SELECT foo = 'foo'"],
            ["SELECT foo = '{}'", ["foo"]   , "SELECT foo = 'foo'"],
            ["SELECT foo = {}", [null]      , "SELECT foo = NULL"],
            ["SELECT foo = '{}'", [null]    , "SELECT foo = 'NULL'"]
        ];
    }
}