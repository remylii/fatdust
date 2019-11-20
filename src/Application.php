<?php
namespace EPGThread;

use EPGThread\Exception\CallToUndefinedMethodException;
use EPGThread\Exception\ViewNotFoundException;

class Application
{
    const VIEW_DIR_PATH = __DIR__ . '/view/';

    public function run(\EPGThread\Action\ActionInterface $action)
    {
        try {
            if (!method_exists($action, $action->method)) {
                throw new CallToUndefinedMethodException();
            }

            $action->{$action->method}($_POST);
            $filepath = static::VIEW_DIR_PATH . $action->view;

            if (!file_exists($filepath)) {
                throw new ViewNotFoundException();
            }

            extract($action->view_props);
        } catch (CallToUndefinedMethodException | ViewNotFoundException $e) {
            var_dump($e);
            $action = new \EPGThread\Action\FailedAction("default");
        } catch (\Throwable $e) {
            var_dump($e);
            $action = new \EPGThread\Action\FailedAction("default");
        }

        // template作るならresponse作る
        include($filepath);
    }
}
