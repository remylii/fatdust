<?php
namespace Test\Action;

use PHPUnit\Framework\TestCase;
use EPGThread\Action\Action;

class ActionTest extends TestCase
{
    /**
     * @dataProvider commonBehaviorProvider
     */
    public function testCommonBehavior($method, $view)
    {
        $action = new Action($method);
        $action->{$method}();

        $this->assertSame($method, $action->method);
        $this->assertSame($view, $action->view);
    }

    public function commonBehaviorProvider(): array
    {
        return [
            ["index", "index.php"],
            ["store", "post.php"]
        ];
    }
}
