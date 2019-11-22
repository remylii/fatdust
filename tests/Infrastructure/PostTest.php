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
}
