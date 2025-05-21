<div class="container py-4">
  <h3>Manage Routes</h3>

  <form class="row g-2 mb-4" method="POST" action="<?= $base_url ?>rbac/saveRoute">
    
      <input type="text" name="name" class="form-control" placeholder="Route Label" required>
    
    
      <input type="text" name="path" class="form-control" placeholder="URL Path" required>
    
    
      <select name="group_id" class="form-select" required>
        <option value="">— Select Group —</option>
        <?php foreach ($routeGroups as $g): ?>
          <option value="<?= $g->id ?>"><?= htmlspecialchars($g->name) ?></option>
        <?php endforeach; ?>
      </select>
 
    
      <button class="btn btn-primary">Add Route</button>
  
  </form><wbr>
  <hr>
  <br>

  <table border="1" class="table table-bordered">
    <thead class="table-light">
      <tr>
        <th>Group</th><th>Name</th><th>Path</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($routes as $r): ?>
      <tr>
        <td><?= htmlspecialchars($r->group_name??'-') ?></td>
        <td><?= htmlspecialchars($r->name) ?></td>
        <td><?= htmlspecialchars($r->path) ?></td>
        <td>
          <a href="<?= $base_url ?>rbac_editRoute/<?= $r->id ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
          <form method="POST" action="<?= $base_url ?>rbac/deleteRoute/<?= $r->id ?>" style="display:inline">
            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')">Delete</button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
