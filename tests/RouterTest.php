<?php
namespace Test;

use PHPUnit\Framework\TestCase;
use EPGThread\Router;

class RouterTest extends TestCase
{
    private $setting_routing_count = 3;

    public function testRoutingMap()
    {
        $obj = new class extends Router {
            public function getRoutingMap()
            {
                return $this->routing_map;
            }
        };

        $routing_map = $obj->getRoutingMap();
        $this->assertEquals($this->setting_routing_count, count($routing_map));

        foreach ($routing_map as $routing) {
            $this->assertEquals(3, count($routing));
            $this->assertTrue(
                in_array($routing[0], [
                    "GET", "POST", "HEAD", "PUT", "DELETE"
                ], true)
            );

            $this->assertTrue(
                method_exists(\EPGThread\Action\Action::class, $routing[2])
            );
        }
    }

    public function testMapRoutingToAction()
    {
        $obj = new class extends Router {
            public function getRoutingMap()
            {
                return $this->routing_map;
            }

            public function getActionMethodRouting()
            {
                return $this->action_method_routing;
            }
        };

        $routing_map = $obj->getRoutingMap();
        $action_method_routing = $obj->getActionMethodRouting();

        $idx = 0;
        foreach ($action_method_routing as $path => $action_routing) {
            $http_method   = $routing_map[$idx][0];
            $expect_path   = $routing_map[$idx][1];
            $expect_action_method = $routing_map[$idx][2];

            $this->assertEquals($expect_path, $path);
            $this->assertEquals(
                $expect_action_method,
                $action_routing[$http_method]
            );

            $action = $obj->mapRoutingToAction($http_method, $expect_path);
            $this->assertEquals(
                \EPGThread\Action\Action::class,
                get_class($action)
            );

            $idx++;
        }
    }

    /**
     * @dataProvider getFailedActionProvider
     */
    public function testGetFailedAction($http_method, $path)
    {
        $router  = new Router();
        $action = $router->mapRoutingToAction($http_method, $path);

        $this->assertEquals(
            \EPGThread\Action\FailedAction::class,
            get_class($action)
        );
    }

    public function getFailedActionProvider(): array
    {
        return [
            ['POST', '/'],
            ['PUT', '/'],
            ['GET', '/post'],
            ['PUT', '/post'],
            ['HEAD', '/post'],
            ['GET', '////'],
            ['GET', '/admin']
        ];
    }
}
