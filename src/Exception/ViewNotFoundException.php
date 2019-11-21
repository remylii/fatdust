<?php
namespace EPGThread\Exception;

class ViewNotFoundException extends \Exception
{
    protected $message = "viewファイルが存在しない";
}
