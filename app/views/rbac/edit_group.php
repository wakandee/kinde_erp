<?php /** @var object $group */ ?>
<div class="container py-4">
  <h2>Edit Module Group</h2>
  <form method="POST" action="<?= $base_url ?>rbac/updateGroup/<?= $group->id ?>">
    <div class="mb-3">
      <label class="form-label">Group Name</label>
      <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($group->name) ?>" required>
    </div><br>
    <button class="btn btn-primary">Save</button>&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="<?= $base_url ?>rbac_module_groups" class="btn btn-secondary">Cancel</a>
  </form>
</div>
