<h3>Departments</h3>
<hr>

<a href="<?= $base_url ?>departments/create">+ Add New</a><br><br>

<table border="1" cellpadding="6">
    <thead>
        <tr>
            <th>Department Name</th>
            <th>No. of Staff</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($departments)): ?>
    <?php foreach ($departments as $department): ?>
        <tr>
            <td><?= htmlspecialchars($department->name); ?></td>
            <td><?= $department->staff_count; ?></td>
           
            <td>
                <a href="<?= $base_url ?>departments/edit/<?= $department->id ?>">Edit</a>
                <form action="<?= $base_url ?>departments/delete/<?= $department->id ?>" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                    <button type="submit">Delete</button>
                </form>

            </td>
        </tr>
    <?php endforeach; ?>
    <?php else: ?>
        <p>No departments Found.</p>
    <?php endif; ?>
    </tbody>
</table>
