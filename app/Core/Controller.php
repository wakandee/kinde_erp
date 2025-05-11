<?php
namespace App\Core;

class Controller {
    /**
     * Shortcut to render a view via the View class.
     *
     * @param string $view  View path under app/Views (e.g. 'auth/login')
     * @param array  $data  Data to pass to the view
     */
    protected function view(string $view, array $data = []): void {
        View::render($view, $data);
    }
}
