<?php

use Clarity\Pipe\Pipe;
use PHPUnit\Framework\TestCase;

final class PipeTest extends TestCase
{
    /**
     * @dataProvider providerForTestPipe
     */
    public function testPipe($expectedOutput, $input)
    {
        $p = Pipe::new(automaticalResponse:false)
        ->append(fn($e)=>$e*5)
        ->append(fn($e)=>$e/5)
        ->append(fn($e)=>$e+10);

        $this->assertEquals($expectedOutput, $p($input));
    }

    public function providerForTestPipe()
    {
        return [
            [15, 05],
            [13, 03],
            [12, 02],
            [5010, 5000],
            [22.5, 12.5]
        ];
    }
}