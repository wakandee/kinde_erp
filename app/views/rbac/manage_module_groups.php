<div>
  <h3>Module (Route) Groups</h3>

  <form method="POST" action="<?= $base_url ?>rbac/saveGroup">
    <input type="text" name="name" placeholder="New Group Name" required>
    <button type="submit">Add Group</button>
  </form>

  <br><hr>

  <table border="1" cellpadding="5" cellspacing="0">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php $count=0; foreach ($groups as $g): $count++; ?>
      <tr>
        <td><?= $count; ?></td>
        <td><?= htmlspecialchars($g->name) ?></td>
        <td>
          <a href="<?= $base_url ?>rbac/editGroup/<?= $g->id ?>">Edit</a>
          <!-- inline delete form -->
          <form method="POST" action="<?= $base_url ?>rbac/deleteGroup/<?= $g->id ?>" style="display:inline">
            <button type="submit" onclick="return confirm('Delete group?')">Delete</button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
