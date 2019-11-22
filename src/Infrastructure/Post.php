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

    public function getPost(): array
    {
        $sql = 'SELECT * FROM posts';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll();

        return $res;
    }

    public function save(string $name, string $comment): bool
    {
        $this->dbh->beginTransaction();
        try {
            $stmt = $this->dbh->prepare("INSERT INTO posts (name, comment) VALUES (:name, :comment)");
            $stmt->bindParam(":name", $name, \PDO::PARAM_STR);
            $stmt->bindParam(":comment", $comment, \PDO::PARAM_STR);
            $stmt->execute();

            $this->dbh->commit();
            return true;
        } catch (\Throwable $e) {
            $this->dbh->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
}
