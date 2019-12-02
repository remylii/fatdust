<?php
namespace EPGThread\Action;

use EPGThread\Response\TemplateResponse;
use EPGThread\Infrastructure\Post;

class Action implements ActionInterface
{
    /** @var string */
    public $method;

    public function __construct(string $method)
    {
        if (!method_exists($this, $method)) {
            throw new \OutOfBoundsException();
        }

        $this->method = $method;
    }

    public function resolveResponse()
    {
        return $this->{$this->method}();
    }

    /**
     * 一覧
     */
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

        return new TemplateResponse("index.php", [
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
     */
    public function store()
    {
        $view  = "post.php";
        $props = [
            "redirect_url" => "http://localhost:8080/"
        ];

        $name     = (isset($_POST["author"]) && $_POST["author"] !== "") ? $_POST["author"] : null;
        $comment  = (isset($_POST["comment"]) && $_POST["comment"] !== "") ? $_POST["comment"] : null;
        $password = (isset($_POST["comment-password"]) && $_POST["comment-password"] !== "") ? $_POST["comment-password"] : null;

        if (!$name || !$comment || !$password) {
            return new TemplateResponse($view, $props);
        }

        $post = new Post();
        if (!$post->saveNewPost($name, $comment, $password)) {
            error_log("Failed: saveNewPost");
            return new TemplateResponse($view, $props);
        }

        return new TemplateResponse($view, $props);
    }

    /**
     * 削除
     */
    public function delete()
    {
        $view  = "delete.php";
        $props = [
            'redirect_url' => "http://localhost:8080/"
        ];

        $id  = (isset($_POST["id"]) && $_POST["id"] !== "") ? $_POST["id"] : null;
        $password = (isset($_POST["delete_password"]) && $_POST["delete_password"] !== "") ? $_POST["delete_password"] : null;

        if (!$id || !$password) {
            error_log("Empty POST parameters");
            return new TemplateResponse($view, $props);
        }

        $post = new Post();
        if (!$post->deletePost($id, $password)) {
            error_log("Failed deletePost");
            return new TemplateResponse($view, $props);
        }

        return new TemplateResponse($view, $props);
    }
}
