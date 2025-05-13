<h2><?= isset($department) ? 'Edit' : 'Create' ?> Department</h2>
<?php //var_dump($department); ?>
<form method="POST" action="<?= isset($department) ? $base_url . 'departments/update/' . $department->id : $base_url . 'departments' ?>">
    <input type="text" name="name" value="<?= $department->name ?? '' ?>" required>
    <button type="submit">Save</button>
</form>
