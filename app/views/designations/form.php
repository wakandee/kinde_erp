<h2><?= isset($designation) ? 'Edit' : 'Create' ?> Designation</h2>
<form method="POST" action="<?= isset($designation) ? $base_url . 'designations/update/' . $designation->id : $base_url . 'designations' ?>">
    <label for="name">Designation Name:</label>
    <input type="text" name="name" value="<?= $designation->name ?? '' ?>" required><br><br>

    <label for="department_id">Department:</label>

    <select name="department_id" required>
        <option value="" disabled>-- Select Department --</option>
            <?php foreach ($departments as $dept): ?>
                <option value="<?= $dept->id ?>" <?= (isset($designation) && $designation->department_id == $dept->id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($dept->name) ?>
                    <?= (isset($designation) && $designation->department_id == $dept->id) ? ' -- Current' : '' ?> 
                </option>
            <?php endforeach; ?>
    </select>
    <br><br>

    <button type="submit">Save</button>
</form>
