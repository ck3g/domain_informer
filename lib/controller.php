<?php

abstract class BaseController {

    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    protected function render($view = 'index') {
        $filename = "app/views/{$this->name}/{$view}.php";
        
        if (!file_exists($filename))
            throw new ViewNotFoundException("{$this->name}Controller->{$view} not found");

        require $filename;
    }

    protected function redirect($url) {
        header("Location: {$url}", true, 303);
        exit(0);
    }

}
