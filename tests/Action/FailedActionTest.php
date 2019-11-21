<?php
namespace Test;

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

        $this->assertEquals($method, $action->method);
        $this->assertEquals($view, $action->view);
    }

    public function commonBehaviorProvider(): array
    {
        return [
            ["default", "500.php"],
            ["notFound", "404.php"]
        ];
    }
}
