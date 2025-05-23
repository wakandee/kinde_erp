<h3>Designations </h3>
<hr>
<a href="<?= $base_url ?>designations/create">+ Add New Designation</a><br><br>

<table border="1" cellpadding="6">
    <thead>
        <tr>
            <th>Designation Name</th>
            <th>Department</th>
            <th>No. of Staff</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($designations)): ?>
    <?php foreach ($designations as $designation): ?>
        <tr>
            <td><?= htmlspecialchars($designation->name); ?></td>
            <td><?= htmlspecialchars($designation->department_name); ?></td>
            <td><?= $designation->staff_count; ?></td>
            <td>
                <a href="<?= $base_url ?>designations/edit/<?= $designation->id ?>">Edit</a>
                <a href="<?= $base_url ?>designations/delete/<?= $designation->id ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php else: ?>
        <p>No designations Found.</p>
    <?php endif; ?>
    </tbody>
</table>