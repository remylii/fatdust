<?php
namespace EPGThread\Action;

interface ActionInterface
{
    public function __construct(string $method);

    public function setView(string $view): void;
}
