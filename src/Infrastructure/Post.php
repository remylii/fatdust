<?php
namespace EPGThread\Infrastructure;

use EPGThread\Infrastructure\DB;

class Post
{
    /** @var \PDO */
    protected $dbh;

    public function __construct()
    {
        $this->dbh = DB::getInstance();
    }

    public function getPost()
    {
        $sql = 'SELECT * FROM posts';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll();

        return $res;
    }
}
