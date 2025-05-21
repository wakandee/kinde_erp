<h3><?= isset($department) ? 'Edit' : 'Create' ?> Department</h3>
<hr>
<?php var_dump($base_url); ?>
<form method="POST" action="<?= isset($department) ? $base_url . 'departments/update/' . $department->id : $base_url . 'departments' ?>">
    <br><label> Department Name:</label><br>
    <input type="text" name="name" value="<?= $department->name ?? '' ?>" required>
    <button type="submit">Save</button>
</form>
