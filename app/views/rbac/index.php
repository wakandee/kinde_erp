<?php use App\Helpers\UrlHelper; ?>
<div class="container py-4">
  <h3 class="mb-4">Role‑Based Access Control</h3>

  <div class="mb-3">
    <label for="designationSelect" class="form-label fw-bold">Select Designation</label>
    <select id="designationSelect" class="form-select">
      <option value="">-- Choose Designation --</option>
      <?php foreach ($designations as $d): ?>
        <option value="<?= $d->id ?>">
          <?= htmlspecialchars($d->name) ?> (<?= htmlspecialchars($d->department_name) ?>)
        </option>
      <?php endforeach; ?>
    </select>
  </div><wbr>
  <hr>

  <div id="rbacMatrixContainer" class="mt-4" style="display:none;">
    <form id="rbacForm">
      <table border="1" class="table table-striped table-bordered">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Route Group</th>
            <th>Path</th>
            <th>Route Name</th>            
            
            <?php  foreach ($permissions as $perm):?>
              <th class="text-center"><?= htmlspecialchars($perm->name) ?></th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <?php $count =0; foreach ($routes as $r):  $count++ ?>
            <tr data-route-id="<?= $r->id ?>">
              <td><?php echo $count; ?></td>
              <td><?= htmlspecialchars($r->group_name) ?></td>
              <td><small><?= htmlspecialchars($r->path) ?></small></td>
                <td><br><?= htmlspecialchars($r->name) ?></td>
              <?php foreach ($permissions as $perm): ?>
                <td class="text-center align-middle">
                  <input type="checkbox"
                         class="role-checkbox"
                         data-route-id="<?= $r->id ?>"
                         data-permission-id="<?= $perm->id ?>">
                </td>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <br>
      <button type="submit" class="btn btn-primary">Save Permissions</button>
    </form>
  </div>
</div>

<script>
(() => {
  const baseUrl = '<?= UrlHelper::getBaseUrl() ?>';
  const sel     = document.getElementById('designationSelect');
  const container = document.getElementById('rbacMatrixContainer');
  const form    = document.getElementById('rbacForm');
  let currentDid = null;

  sel.addEventListener('change', async () => {
    currentDid = sel.value;
    container.style.display = currentDid ? '' : 'none';
    if (! currentDid) return;

    const res    = await fetch(`${baseUrl}rbac/matrix/${currentDid}`);
    const matrix = await res.json();

    document.querySelectorAll('.role-checkbox').forEach(cb => cb.checked = false);
    matrix.forEach(m => {
      const selector = `.role-checkbox[data-route-id="${m.route_id}"][data-permission-id="${m.permission_id}"]`;
      const cb = document.querySelector(selector);
      if (cb) cb.checked = true;
    });
  });

  form.addEventListener('submit', async e => {
    e.preventDefault();
    if (! currentDid) return;
    const roles = [];
    document.querySelectorAll('.role-checkbox').forEach(cb => {
      if (cb.checked) {
        roles.push([cb.dataset.routeId, cb.dataset.permissionId]);
      }
    });
    const resp = await fetch(`${baseUrl}rbac/matrix/save`, {
      method: 'POST',
      headers: {'Content-Type':'application/json'},
      body: JSON.stringify({designation_id: currentDid, roles})
    });
    const json = await resp.json();
    alert(json.success ? 'Saved!' : 'Error.');
  });
})();
</script>
