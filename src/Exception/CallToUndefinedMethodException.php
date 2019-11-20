<?php
namespace EPGThread\Exception;

class CallToUndefinedMethodException extends \Exception
{
    protected $message = "メソッドが存在しない";
}
