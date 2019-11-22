<?php
namespace Test\Action;

use PHPUnit\Framework\TestCase;
use EPGThread\Action\FailedAction;

class FailedActionTest extends TestCase
{
    /**
     * @dataProvider commonBehaviorProvider
     */
    public function testCommonBehavior($method, $view)
    {
        $action = new FailedAction($method);
        $action->{$method}();

        $this->assertSame($method, $action->method);
        $this->assertSame($view, $action->view);
    }

    public function commonBehaviorProvider(): array
    {
        return [
            ["default", "500.php"],
            ["notFound", "404.php"]
        ];
    }
}
