<h3>Departments</h3>

<a href="<?= $base_url ?>departments/create">Add New</a>

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
            <td></td>
           
            <td>
                <a href="<?= $base_url ?>departments/edit/<?= $department->id ?>">Edit</a>
                <!-- <a href="<?= $base_url ?>departments/<?= $department->id ?>/edit">Edit</a> -->
                <a href="<?= $base_url ?>departments/delete/<?= $department->id ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php else: ?>
        <p>No departments Found.</p>
    <?php endif; ?>
    </tbody>
</table>
