<?php
namespace EPGThread\Action;

class Action implements ActionInterface
{
    public $method;
    public $view;
    public $view_props = [];

    public function __construct(string $method)
    {
        $this->method = $method;
    }

    public function index()
    {
        $this->setView("index.php");
        $this->setViewProps([
            "str" => "Hi"
        ]);
    }

    public function store($data = [])
    {
        var_dump($data);
        $this->setView("post.php");
    }

    public function setViewProps(array $props): void
    {
        $this->view_props = $props;
    }

    public function setView(string $view): void
    {
        $this->view = $view;
    }
}
