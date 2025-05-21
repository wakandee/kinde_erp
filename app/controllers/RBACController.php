<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\Auth;
use App\Models\Designation;
use App\Models\UserRoute;
use App\Models\UserRouteGroup;
use App\Models\UserPermission;
use App\Models\UserDesignationRole;
use App\Middleware\Rbac;

class RbacController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::handle();

        // Only allow users with the “Assign” permission on the RBAC page
        $this->authorize('View','rbac_routes');    // ensure “View” permission on this route
    }

    //
    // —————————————————————————————————————————————————————————————————————————
    // 1) Permission‑Matrix (assign view/create/edit/delete/etc. per designation)
    // —————————————————————————————————————————————————————————————————————————
    //

    // GET /rbac
    public function index()
    {
        // the constructor already ran the view on rbac
        $designations = Designation::all();
        // we’ll pull group_name via a JOIN in allWithGroup()
        $routes       = UserRoute::allWithGroup();  
        $permissions  = UserPermission::all_active();
        $routeGroups  = UserRouteGroup::all();

        $this->view('rbac/index', compact(
            'designations','routes','permissions','routeGroups'
        ));
    }

    // GET /rbac/matrix/{id}
    public function getMatrix($designationId)
    {
        $this->authorize('Edit', 'rbac_access_control');
        header('Content-Type: application/json');
        echo json_encode(
            UserDesignationRole::getByDesignation((int)$designationId)
        );
        exit;
    }



    // POST /rbac/matrix/save
    public function saveMatrix()
    {
        $this->authorize('Create', 'rbac_access_control');
        $body = json_decode(file_get_contents('php://input'), true);
        UserDesignationRole::updateMatrix(
            (int)($body['designation_id'] ?? 0),
            $body['roles']          ?? []
        );
        echo json_encode(['success' => true]);
        exit;
    }


    //
    // —————————————————————————————————————————————————————————————————————————
    // 2) Module‑Groups CRUD
    // —————————————————————————————————————————————————————————————————————————
    //

    // GET  /rbac/manage_module_groups
    public function manage_module_groups()
    {
        // the constructor already ran the view on rbac
        $groups = UserRouteGroup::all();
        $this->view('rbac/manage_module_groups', compact('groups'));
    }

    // POST /rbac/saveGroup
    public function saveGroup()
    {
        $this->authorize('Create','rbac_routes');
        $name = trim($_POST['name'] ?? '');
        
        $data = ['name'     => $name];

        UserRouteGroup::create($data);
        header("Location: {$this->baseUrl}rbac_module_groups");
        exit;
    }

    // GET  /rbac/editGroup/{id}
    public function editGroup($id)
    {
        $this->authorize('Edit', 'rbac_routes');
        $group = UserRouteGroup::find((int)$id);
        $this->view('rbac/edit_group', compact('group'));
    }

    // POST /rbac/updateGroup/{id}
    public function updateGroup($id)
    {
        $this->authorize('Edit', 'rbac');
        $name = trim($_POST['name'] ?? '');
        UserRouteGroup::update((int)$id, $name);
        header("Location: {$this->baseUrl}rbac_module_groups");
        exit;
    }

    // POST /rbac/deleteGroup/{id}
    public function deleteGroup($id)
    {
        $this->authorize('Delete','rbac_routes');
        UserRouteGroup::delete((int)$id);
        header("Location: {$this->baseUrl}rbac_module_groups");
        exit;
    }


    //
    // —————————————————————————————————————————————————————————————————————————
    // 3) Routes CRUD
    // —————————————————————————————————————————————————————————————————————————
    //

    // GET  /rbac/manage_routes
    public function manage_routes()
    {
        // the constructor already ran the view on rbac
        $routes      = UserRoute::allWithGroup();
        $routeGroups = UserRouteGroup::all();
        $this->view('rbac/manage_routes', compact('routes','routeGroups'));
    }

    // POST /rbac/saveRoute
    public function saveRoute()
    {
        $this->authorize('Create', 'rbac_routes');
        $name    = trim($_POST['name'] ?? '');
        $path    = trim($_POST['path'] ?? '');
        $groupId = (int)($_POST['group_id'] ?? 0);
        $data = ['name'     => $name,
                 'path' => $path,
                'group_id' => $groupId];
        UserRoute::create($data);
        header("Location: {$this->baseUrl}rbac_routes");
        exit;
    }

    // GET  /rbac/editRoute/{id}
    public function editRoute($id)
    {
        $this->authorize('View','rbac_routes');
        $route       = UserRoute::find((int)$id);
        $routeGroups = UserRouteGroup::all();
        $this->view('rbac/edit_route', compact('route','routeGroups'));
    }

    // POST /rbac_updateRoute/{id}

    public function updateRoute($id)
    {
        $this->authorize('Edit','rbac_routes');

        $name    = trim($_POST['name']     ?? '');
        $path    = trim($_POST['path']     ?? '');
        $groupId = (int)($_POST['group_id'] ?? 0);

        // Build a data array instead of multiple params:
        $data = [
            'name'     => $name,
            'path'     => $path,
            'group_id' => $groupId,
        ];

        UserRoute::update((int)$id, $data);

        header("Location: {$this->baseUrl}rbac_routes");
        exit;
    }


    // POST /rbac/deleteRoute/{id}
    public function deleteRoute($id)
    {
        $this->authorize('Delete','rbac');
        UserRoute::delete((int)$id);
        header("Location: {$this->baseUrl}rbac_routes");
        exit;
    }


    //
    // —————————————————————————————————————————————————————————————————————————
    // 4) Permissions CRUD (basic list; you can extend for Create/Edit/Delete)
    // —————————————————————————————————————————————————————————————————————————
    //

    // GET /rbac/manage_permissions
    public function manage_permissions()
    {
        $permissions = UserPermission::all();
        $this->view('rbac/manage_permissions', compact('permissions'));
    }

    // (extend here with savePermission(), editPermission(), etc., as needed)
}
