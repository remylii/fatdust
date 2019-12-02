<?php
namespace Test\Action;

use PHPUnit\Framework\TestCase;
use EPGThread\Action\FailedAction;
use EPGThread\Response\TemplateResponse;

class FailedActionTest extends TestCase
{
    /**
     * @dataProvider commonBehaviorProvider
     */
    public function testCommonBehavior($method, $view)
    {
        $action = new FailedAction($method);
        $response = $action->{$method}();

        $this->assertSame($method, $action->method);
        $this->assertSame($view, $response->filepath);
    }

    public function commonBehaviorProvider(): array
    {
        $view_dir = TemplateResponse::VIEW_DIR_PATH;
        return [
            ["default",  $view_dir . "500.php"],
            ["notFound", $view_dir . "404.php"]
        ];
    }
}
