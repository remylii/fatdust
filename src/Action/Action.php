<?php
namespace EPGThread\Action;

use EPGThread\Infrastructure\Post;

class Action extends ActionAbstract
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
        $post = new Post();
        $posts = $post->getPost();

        $this->setView("index.php");
        $this->setViewProps([
            "title" => "一覧",
            "posts" => $posts,
        ]);
    }

    public function store()
    {
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
