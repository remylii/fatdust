<?php
namespace EPGThread\Action;

abstract class ActionAbstract
{
    public $method;
    public $view;
    public $view_props;

    abstract public function __construct(string $method);

    abstract public function setView(string $view): void;
}
