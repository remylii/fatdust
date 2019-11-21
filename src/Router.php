<?php
namespace EPGThread;

use EPGThread\Action\Action;
use EPGThread\Action\FailedAction;
use EPGThread\Action\ActionInterface;

class Router
{
    /**
     * @var array routing
     */
    protected $routing_map = [
        ["GET",  "/",     "index"],
        ["POST", "/post", "store"],
    ];

    /**
     * @var array 0: string URL path, 1: string HTTP_METHOD, value: string Action.method
     * e.g.) $action_method_routing["/"]["GET"] = "index"
     */
    protected $action_method_routing = [];


    public function __construct()
    {
        foreach ($this->routing_map as $value) {
            $this->action_method_routing[$value[1]][$value[0]] = $value[2];
        }
    }

    public function mapRoutingToAction(string $http_method, string $path): ActionInterface
    {
        $http_method = ($http_method === 'HEAD') ? "GET" : $http_method;

        if (!isset($this->action_method_routing[$path][$http_method])) {
            return $this->getHttpFailedAction();
        }

        return new Action($this->action_method_routing[$path][$http_method]);
    }

    public function getHttpFailedAction(): ActionInterface
    {
        return new FailedAction("notFound");
    }
}
