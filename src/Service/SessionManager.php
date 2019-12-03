<?php
namespace EPGThread\Service;

/**
 * SessionのInterface
 */
class SessionManager
{
    public function __construct()
    {
        if (@session_start() === false) {
            // throw new \Exception("セッションが開始できない");
        }
    }

    public function __destruct()
    {
        session_write_close();
    }

    public function get($key)
    {
        if (!isset($_SESSION[$key])) {
            return null;
        }

        $payload = $_SESSION[$key];
        if (!isset($payload["value"])) {
            return null;
        }

        if (isset($payload["attribute"]) && $payload["attribute"] === "flash") {
            unset($_SESSION[$key]);
        }

        return $payload["value"];
    }

    public function write($key, $value)
    {
        $payload = $this->payloadFormat($value);
        $this->save($key, $payload);
    }

    public function flash($key, $value)
    {
        $payload = $this->payloadFormat($value, "flash");
        $this->save($key, $payload);
    }

    private function save($key, $payload)
    {
        $_SESSION[$key] = $payload;
    }

    private function payloadFormat($value, $attribute = null)
    {
        return [
            "value"     => $value,
            "attribute" => $attribute,
        ];
    }
}
