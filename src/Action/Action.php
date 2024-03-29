<?php
namespace EPGThread\Action;

use EPGThread\Service\SessionManager as Session;
use EPGThread\Response\TemplateResponse;
use EPGThread\Repository\Post;

class Action implements ActionInterface
{
    /** @var string */
    public $method;

    public $session;

    public function __construct(string $method)
    {
        if (!method_exists($this, $method)) {
            throw new \OutOfBoundsException();
        }

        $this->method = $method;
        $this->session = new Session();
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
            "redirect_message" => $this->session->get("redirect_message"),
            "errors"  => $this->session->get("errors"),
        ]);
    }

    /**
     * 保存
     */
    public function store()
    {
        $view  = "post.php";
        $props = [
            "redirect_url" => $_SERVER['HTTP_REFERER'] ?? "/"
        ];

        $name     = (isset($_POST["author"]) && $_POST["author"] !== "") ? $_POST["author"] : null;
        $comment  = (isset($_POST["comment"]) && $_POST["comment"] !== "") ? $_POST["comment"] : null;
        $password = (isset($_POST["comment-password"]) && $_POST["comment-password"] !== "") ? $_POST["comment-password"] : null;

        if (!$name || !$comment || !$password) {
            $this->session->flash("errors", [
                [
                    "message" => "項目がたりません"
                ]
            ]);
            return new TemplateResponse($view, $props);
        }

        $post = new Post();
        if (!$post->saveNewPost($name, $comment, $password)) {
            error_log("Failed: saveNewPost");
            $this->session->flash("errors", [
                [
                    "message" => "Failed: post"
                ]
            ]);
            return new TemplateResponse($view, $props);
        }

        // session
        $this->session->flash("redirect_message", "投稿が完了しました");

        return new TemplateResponse($view, $props);
    }

    /**
     * 削除
     */
    public function delete()
    {
        $view  = "delete.php";
        $props = [
            "redirect_url" => $_SERVER['HTTP_REFERER'] ?? "/"
        ];

        $id  = (isset($_POST["id"]) && $_POST["id"] !== "") ? $_POST["id"] : null;
        $password = (isset($_POST["delete_password"]) && $_POST["delete_password"] !== "") ? $_POST["delete_password"] : null;

        if (!$id || !$password) {
            error_log("Empty POST parameters");
            $this->session->flash("errors", [
                ["message" => "項目がたりません"]
            ]);
            return new TemplateResponse($view, $props);
        }

        $post = new Post();
        if (!$post->deletePost($id, $password)) {
            error_log("Failed deletePost");
            $this->session->falsh("errors", [
                ["message" => "Failed: delete post"]
            ]);
            return new TemplateResponse($view, $props);
        }

        $this->session->flash("redirect_message", "投稿を削除しました");
        return new TemplateResponse($view, $props);
    }
}
