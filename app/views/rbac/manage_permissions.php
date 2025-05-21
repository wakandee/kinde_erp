<div class="container py-4">
  <h2>Manage Permissions</h2>

  <table class="table table-striped">
    <thead><tr><th>ID</th><th>Name</th></tr></thead>
    <tbody>
      <?php foreach ($permissions as $p): ?>
        <tr>
          <td><?= $p->id ?></td>
          <td><?= htmlspecialchars($p->name) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- You can later add forms to create/edit/delete permissions here -->
</div>
