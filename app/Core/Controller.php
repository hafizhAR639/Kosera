<?php

namespace App\Core;

abstract class Controller
{
    protected function render(string $view, array $data = [], ?string $layout = null): void
    {
        View::render($view, $data, $layout);
    }

    protected function redirect(string $location): void
    {
        header('Location: ' . $location);
        exit();
    }
}
