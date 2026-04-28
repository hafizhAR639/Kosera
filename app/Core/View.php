<?php

namespace App\Core;

class View
{
    public static function render(string $view, array $data = [], ?string $layout = null): void
    {
        $content = self::capture($view, $data);

        if ($layout === null) {
            echo $content;
            return;
        }

        extract($data, EXTR_SKIP);
        $layoutPath = __DIR__ . '/../Views/layouts/' . $layout . '.php';

        if (!file_exists($layoutPath)) {
            throw new \RuntimeException('Layout tidak ditemukan: ' . $layout);
        }

        include $layoutPath;
    }

    private static function capture(string $view, array $data): string
    {
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            throw new \RuntimeException('View tidak ditemukan: ' . $view);
        }

        extract($data, EXTR_SKIP);
        ob_start();
        include $viewPath;

        return (string)ob_get_clean();
    }
}
