<?php
namespace EPGThread\Action;

use EPGThread\Response\TemplateResponse;

class FailedAction implements ActionInterface
{
    public $method;

    public function __construct(string $method = 'default')
    {
        $this->method = $method;
    }

    public function resolveResponse()
    {
        return $this->{$this->method}();
    }

    public function default()
    {
        return new TemplateResponse("500.php");
    }

    public function notFound()
    {
        return new TemplateResponse("404.php");
    }
}
