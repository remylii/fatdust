<?php
namespace EPGThread\Response;

class TemplateResponse
{
    const VIEW_DIR_PATH = __DIR__ . '/../view/';

    /** @var string */
    public $filepath;

    /** @var array */
    public $props = [];

    public function __construct($filename, $props = [])
    {
        $this->filepath = static::VIEW_DIR_PATH . $filename;
        $this->props = $props;
    }

    public function render()
    {
        extract($this->props);

        return include($this->filepath);
    }
}
