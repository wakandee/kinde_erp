<h2><?= isset($designation) ? 'Edit' : 'Create' ?> Designation</h2>
<form method="POST" action="<?= isset($designation) ? $base_url . 'designations/update/' . $designation['designation_id'] : $base_url . 'designations' ?>">
    <label for="name">Designation Name:</label>
    <input type="text" name="name" value="<?= $designation['name'] ?? '' ?>" required>

    <label for="department_id">Department:</label>
    <select name="department_id" required>
        <option value="">-- Select Department --</option>
        <?php foreach ($departments as $dept): ?>
    <option value="<?= $dept->department_id ?>" <?= (isset($designation) && $designation['department_id'] == $dept->department_id) ? 'selected' : '' ?>>
        <?= htmlspecialchars($dept->name) ?>
    </option>
<?php endforeach; ?>

    </select>

    <button type="submit">Save</button>
</form>
