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
        $latest = true;
        $page   = 1;
        if (isset($_GET["page"]) && $_GET["page"] !== "" && (int)$_GET["page"] !== 0) {
            $latest = false;
            $page   = (int)$_GET["page"];
        }

        $post = new Post();
        $posts = $post->getPostWithPagination($latest, $page);

        $this->setView("index.php");
        $this->setViewProps([
            "title"   => "一覧",
            "posts"   => $posts["rows"],
            "latest"  => $latest,
            "last"    => $posts["pagination"]["last"],
            "limit"   => $posts["pagination"]["limit"],
            "current" => $posts["pagination"]["current"],
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

        $name     = (isset($_POST["author"]) && $_POST["author"] !== "") ? $_POST["author"] : null;
        $comment  = (isset($_POST["comment"]) && $_POST["comment"] !== "") ? $_POST["comment"] : null;
        $password = (isset($_POST["comment-password"]) && $_POST["comment-password"] !== "") ? $_POST["comment-password"] : null;

        if (!$name || !$comment || !$password) {
            return;
        }

        $post = new Post();
        if (!$post->saveNewPost($name, $comment, $password)) {
            \error_log("Failed: saveNewPost");
            return;
        }
    }

    /**
     * 削除
     */
    public function delete()
    {
        $this->setView("delete.php");
        $this->setViewProps([
            'redirect_url' => "http://localhost:8080/"
        ]);

        $id  = (isset($_POST["id"]) && $_POST["id"] !== "") ? $_POST["id"] : null;
        $password = (isset($_POST["delete_password"]) && $_POST["delete_password"] !== "") ? $_POST["delete_password"] : null;

        if (!$id || !$password) {
            error_log("Empty POST parameters");
            return;
        }

        $post = new Post();
        if (!$post->deletePost($id, $password)) {
            \error_log("Failed deletePost");
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
