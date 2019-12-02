<?php
namespace EPGThread;

class Application
{
    public function run(\EPGThread\Action\ActionInterface $action)
    {
        try {
            $response = $action->resolveResponse();
        } catch (\Throwable $e) {
            var_dump($e);

            $action = new \EPGThread\Action\FailedAction();
            $response = $action->resolveResponse();
        }

        return $response;
    }
}
