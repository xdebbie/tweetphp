<?php

namespace Twitter\Controller;

use Twitter\Http\Response;

abstract class Controller
{
    protected function render(string $path, array $variables = [])
    {
        extract($variables);

        // tweet/list
        ob_start();
        require __DIR__ . '/../../templates/' . $path . '.html.php';
        $html = ob_get_clean();

        return new Response($html);
    }

    protected function redirect(string $url)
    {
        return new Response('', 302, [
            'Location' => $url
        ]);
    }
}
