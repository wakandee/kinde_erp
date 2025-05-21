<?php
// app/Core/Controller.php

namespace App\Core;

use App\Core\View;
use App\Helpers\SessionHelper;
use App\Middleware\Rbac;


abstract class Controller
{
    /** The base URL (from env or session) */
    protected string $baseUrl;

    public function __construct()
    {
        // always start the session
        SessionHelper::start();
        $this->baseUrl = $_ENV['BASE_URL'] 
                       ?? $_SESSION['base_url'] 
                       ?? '/';
    }

    /**
     * Render a view, injecting base_url plus any passed data.
     */
    protected function view(string $view, array $data = []): void
    {
        $data['base_url'] = $this->baseUrl;
        View::render($view, $data);
    }

    /**
     * Enforce that the current user has $permission on the current route.
     * Call this in your controller methods or constructor.
     *
     * @param string $permission  One of your permissions: "View", "Create", "Edit", etc.
     */
    protected function authorize(string $permission = 'View', string $routePath = null): void
    {
        // this will detect the route automatically and return 403 if missing

        // var_dump($routePath);exit();
        Rbac::enforce($permission,$routePath);
    }
}
