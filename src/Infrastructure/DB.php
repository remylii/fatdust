<?php
namespace EPGThread\Infrastructure;

class DB
{
    /**
     * @var \PDO singleton
     */
    private static $db;

    private $driver;
    private $host;
    private $port;
    private $dbname;
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

    public static function getDataType($val)
    {
        $type = gettype($val);
        switch ($type) {
            case "string":
                return \PDO::PARAM_STR;
            case "integer":
                return \PDO::PARAM_INT;
            case "boolean":
                return \PDO::PARAM_BOOL;
            case "NULL":
                return \PDO::PARAM_NULL;
            default:
                return \PDO::PARAM_STR;
        }
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
