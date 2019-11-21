<?php
namespace EPGThread\Infrastructure;

class DB
{
    /**
     * @var \PDO singleton
     */
    private static $db;

    private $dbname;
    private $host;
    private $charset;
    private $username;
    private $password;
    private $driver_options;

    public static function getInstance(): \PDO
    {
        if (!isset(self::$db)) {
            self::$db = (new DB())->connection();
        }

        return self::$db;
    }

    private function __construct()
    {
        $config = require_once __DIR__ . "/config.php";

        $this->driver         = $config["driver"];
        $this->host           = $config["host"];
        $this->port           = $config["port"];
        $this->dbname         = $config["dbname"];
        $this->charset        = $config["charset"] ?? "utf8mb4";
        $this->username       = $config["username"];
        $this->password       = $config["password"];
        $this->driver_options = $config["driver_options"];
    }

    private function connection()
    {
        try {
            $db = new \PDO(
                $this->driver.":".
                \implode(";", [
                    "host=" . $this->host,
                    "port= " . $this->port,
                    "dbname=" . $this->dbname,
                    "charset=" . $this->charset,
                ]),
                $this->username,
                $this->password,
                $this->driver_options
            );

            return $db;
        } catch (\PDOException $e) {
            throw $e;
        }
    }
}
