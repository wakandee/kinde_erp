<?php
$departments  = $departments  ?? [];
$designations = $designations ?? [];


// var_dump($user);
?>

<h3><?= isset($user) ? 'Edit User' : 'Add New User' ?></h3>
<hr>

<form method="POST" action="<?= isset($user) ? $base_url . 'users/' . $user->id : $base_url . 'users' ?>">

    <label>Name:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text" name="name" value="<?= $user->name ?? '' ?>" required><br><br>

    <label>Email:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="email" name="email" value="<?= $user->email ?? '' ?>" required><br><br>

    <label>Username:</label>
    <input type="text" name="username" value="<?= $user->username ?? '' ?>" required><br><br>

    <label>Password: <?= isset($user) ? '(Leave blank to keep current)' : '' ?></label>
    <input type="password" name="password" autocomplete="new-password"><br><br>

    <label>Phone No:</label>
    <input type="text" name="phone_number" value="<?= $user->phone_number ?? '' ?>"><br><br>

    <label>Department:</label>
    <select name="department_id" required>
        <option value="">-- Select Department --</option>
        <?php foreach ($departments as $dept): ?>
            <option value="<?= $dept->id ?>" <?= (isset($user) && $user->department_id == $dept->id) ? 'selected' : '' ?>>
                <?= htmlspecialchars($dept->name) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Designation:</label>
    <select name="designation_id" required>
        <option value="">-- Select Designation --</option>
        <?php foreach ($designations as $des): ?>
            <option value="<?= $des->designation_id ?? $des->id ?>" <?= (isset($user) && $user->designation_id == ($des->designation_id ?? $des->id)) ? 'selected' : '' ?>>
                <?= htmlspecialchars($des->name) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit"><?= isset($user) ? 'Update' : 'Create' ?></button>
</form>

<script>
document.querySelector('select[name="department_id"]').addEventListener('change', function () {
    const departmentId = this.value;
    const designationSelect = document.querySelector('select[name="designation_id"]');
    const currentDesignationId = <?= isset($user) ? (int)$user->designation_id : 'null' ?>;

    if (!departmentId) {
        designationSelect.innerHTML = '<option value="">-- Select Designation --</option>';
        return;
    }

    fetch('<?= $base_url ?>designations/by-department/' + departmentId)
        .then(response => response.json())
        .then(data => {
            designationSelect.innerHTML = '<option value="">-- Select Designation --</option>';
            data.forEach(designation => {
                const option = document.createElement('option');
                option.value = designation.id;
                option.textContent = designation.name;
                if (designation.id == currentDesignationId) {
                    option.selected = true;
                }
                designationSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error loading designations:', error);
        });
});
</script>
