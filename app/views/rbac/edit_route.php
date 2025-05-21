<?php 
/** @var object $route */
/** @var array  $routeGroups */
?>
<div class="container py-4">
  <h2>Edit Route</h2>
  <form method="POST" action="<?= $base_url ?>rbac/updateRoute/<?= $route->id ?>">
    <div class="mb-3">
      <label class="form-label">Label</label>
      <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($route->name) ?>" required>
    </div><br>
    <div class="mb-3">
      <label class="form-label">Path</label>
      <input type="text" name="path" class="form-control" value="<?= htmlspecialchars($route->path) ?>" required>
    </div><br>
    <div class="mb-3">
      <label class="form-label">Group</label>
      <select name="group_id" class="form-select" required>
        <?php foreach($routeGroups as $g): ?>
          <option value="<?= $g->id ?>" <?= $g->id === $route->group_id ? 'selected' : '' ?>>
            <?= htmlspecialchars($g->name) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div><br>
    <button class="btn btn-primary">Save</button>
    <a href="<?= $base_url ?>rbac_routes" class="btn btn-secondary">Cancel</a>
  </form>
</div>
