<?php
namespace EPGThread\Infrastructure;

use EPGThread\Infrastructure\DB;

/**
 * repository作るか
 */
class Post
{
    const LiMIT = 3;

    /** @var \PDO */
    protected $dbh;

    public function __construct()
    {
        $this->dbh = DB::getInstance();
    }

    public function getPost($latest = false, $page = 1): array
    {
        $offset = self::LiMIT * ($page - 1);
        $sql = 'SELECT id, uuid, name, comment, posting_datetime, deleted_at FROM posts';
        $sql .= ($latest) ? " ORDER BY ID DESC " : " ORDER BY ID ASC ";
        $sql .= "LIMIT " . $offset . ', ' . self::LiMIT;

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(\PDO::FETCH_CLASS);

        return ($latest) ? array_reverse($res) : $res;
    }

    public function getPostWithPagination($latest = false, $page = 1): array
    {
        $sql = 'SELECT COUNT(id) as cnt FROM posts';
        $stmt = $this->dbh->query($sql);
        $rowCount = $stmt->fetchColumn(0);
        $pagination = [
            "current" => $page,
            "limit"   => self::LiMIT,
            "last"    => ceil($rowCount / self::LiMIT),
        ];

        $rows = $this->getPost($latest, $page);

        return [
            "pagination" => [
                "current" => $page,
                "limit"   => self::LiMIT,
                "last"    => ceil($rowCount / self::LiMIT),
            ],
            "rows" => $rows
        ];
    }

    public function saveNewPost(string $name, string $comment, string $password): bool
    {
        $this->dbh->beginTransaction();
        try {
            $uuid     = uniqid("posts");
            $datetime = date("Y-m-d H:i:s", time());

            $params = [
                $uuid, $name, $comment, password_hash($password, PASSWORD_BCRYPT), $datetime, $datetime
            ];

            $sql = "INSERT INTO posts (uuid, name, comment, password, posting_datetime, created_at) VALUES ";
            $sql .= "(" . implode(", ", array_fill(0, count($params), "?")) . ")";
            $stmt = $this->dbh->prepare($sql);
            foreach ($params as $i => $val) {
                $stmt->bindValue(($i + 1), $val, DB::getDataType($val));
            }

            if (!$stmt->execute()) {
                throw new \Exception("execute failed");
            }

            $this->dbh->commit();
            return true;
        } catch (\Throwable $e) {
            $this->dbh->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    public function deletePost(int $id, string $password)
    {
        try {
            $stmt = $this->dbh->prepare("SELECT id, password FROM posts WHERE id = :id AND deleted_at IS NULL");
            $stmt->bindValue(":id", $id, \PDO::PARAM_INT);
            $stmt->execute();

            $target = $stmt->fetchObject(__CLASS__);

            if (!$target || $stmt->rowCount() !== 1) {
                throw new \OutOfRangeException("違くない？");
            }

            if (!password_verify($password, $target->password)) {
                throw new \DomainException("パスワード違くない？");
            }
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            return false;
        }

        unset($stmt);
        $this->dbh->beginTransaction();
        try {
            $datetime = date("Y-m-d H:i:s", time());

            $stmt = $this->dbh->prepare("UPDATE posts SET deleted_at = :deleted_at where id = :id");
            $stmt->bindValue(":deleted_at", $datetime, \PDO::PARAM_STR);
            $stmt->bindValue(":id", $id, \PDO::PARAM_INT);
            if (!$stmt->execute()) {
                throw new \Exception("Failed deletePost");
            }

            $this->dbh->commit();
            return true;
        } catch (\Throwable $e) {
            $this->dbh->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
}
