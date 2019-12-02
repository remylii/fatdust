<?php
namespace Test\Action;

use PHPUnit\Framework\TestCase;
use EPGThread\Action\Action;
use EPGThread\Response\TemplateResponse;

class ActionTest extends TestCase
{
    /**
     * @dataProvider commonBehaviorProvider
     */
    public function testCommonBehavior($method, $view)
    {
        $action = new Action($method);
        $response = $action->{$method}();

        $this->assertSame($method, $action->method);
        $this->assertSame($view, $response->filepath);
    }

    public function commonBehaviorProvider(): array
    {
        $view_dir = TemplateResponse::VIEW_DIR_PATH;
        return [
            ["index",  $view_dir . "index.php"],
            ["store",  $view_dir . "post.php"],
            ["delete", $view_dir . "delete.php"],
        ];
    }

    public function testIndexProps()
    {
        $action = new Action("index");
        $response = $action->index();

        $keys = [
            "title",
            "posts",
            "latest",
            "last",
            "limit",
            "current",
        ];
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $response->props);
        }
    }
}
