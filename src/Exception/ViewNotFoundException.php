<?php
namespace EPGThread\Exception\ViewNotFoundException;

class ViewNotFoundException extends Exception
{
    protected $message = "viewファイルが存在しない";
}
