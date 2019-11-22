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

    /**
     * 保存
     * @TODO redirect message?
     */
    public function store()
    {
        $this->setView("post.php");
        $this->setViewProps([
            "redirect_url" => "http://localhost:8080/"
        ]);

        $name    = (isset($_POST["author"]) && $_POST["author"] !== "") ? $_POST["author"] : null;
        $comment = (isset($_POST["comment"]) && $_POST["comment"] !== "") ? $_POST["comment"] : null;

        if (!$name || !$comment) {
            return;
        }

        $post = new Post();
        if (!$post->save($name, $comment)) {
            return;
        }
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
