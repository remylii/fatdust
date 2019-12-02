<?php
namespace Test\Infrastructure;

use PHPUnit\Framework\TestCase;
use EPGThread\Infrastructure\Post;

class PostTest extends TestCase
{
    public function testGetPost()
    {
        $post = new Post();
        $res = $post->getPost();
        $this->assertSame('array', gettype($res));
    }

    public function testGetPostWithPagination()
    {
        $post = new Post();
        $res = $post->getPostWithPagination();

        $this->assertArrayHasKey("pagination", $res);
        $this->assertArrayHasKey("current", $res["pagination"]);
        $this->assertArrayHasKey("limit", $res["pagination"]);
        $this->assertArrayHasKey("last", $res["pagination"]);
        $this->assertArrayHasKey("rows", $res);
    }
}
