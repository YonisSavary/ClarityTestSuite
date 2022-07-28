<?php

use Clarity\Clarity;
use Clarity\Renderer\Renderer;
use PHPUnit\Framework\TestCase;

final class RendererTest extends TestCase
{
    /**
     * @dataProvider pathProvider
     */
    public function testPath(string $expectedPath=null, string $resultPath=null)
    {
        $this->assertEquals($expectedPath, $resultPath);
    }

    public function pathProvider()
    {
        $viewsPath = Clarity::getDirectory() . "ClarityTestSuite/Views/";
        return [
            [$viewsPath."base/base.php"     , Renderer::findTemplateFile("base")         ],
            [$viewsPath."article/A.php"     , Renderer::findTemplateFile("A")            ],
            [$viewsPath."components/A.php"  , Renderer::findTemplateFile("components/A") ],
            [$viewsPath."components/A.php"  , Renderer::findTemplateFile("components\\A")]
        ];
    }
}