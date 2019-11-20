<?php
namespace EPGThread\Action;

class FailedAction implements ActionInterface
{
    public $method;
    public $view;
    public $view_props = [];

    public function __construct(string $method)
    {
        $this->method = $method;
    }

    public function default()
    {
        $this->setView("500.php");
    }

    public function notFound()
    {
        $this->setView("404.php");
    }

    public function setView(string $view): void
    {
        $this->view = $view;
    }
}
