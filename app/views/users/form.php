<h2><?= isset($user) ? 'Edit User' : 'Add New User' ?></h2>

<form method="POST" action="<?= isset($user) ? $base_url . 'users/' . $user->id : $base_url . 'users' ?>">

    <label>Name:</label><br>
    <input type="text" name="name" value="<?= $user->name ?? '' ?>" required><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= $user->email ?? '' ?>" required><br>

    <label>Username:</label><br>
    <input type="text" name="username" value="<?= $user->username ?? '' ?>" required><br>

    <label>Password: <?= isset($user) ? '(Leave blank to keep current)' : '' ?></label><br>
    <input type="password" name="password"><br>

    <label>Phone Number:</label><br>
    <input type="text" name="phone_number" value="<?= $user->phone_number ?? '' ?>"><br>

    <label>Department:</label><br>
    <select name="department_id" required>
        <option value="">-- Select Department --</option>
        <?php foreach ($departments as $dept): ?>
            <option value="<?= $dept->id ?>" <?= (isset($user) && $user->department_id == $dept->department_id) ? 'selected' : '' ?>>
                <?= htmlspecialchars($dept->name) ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <label>Designation:</label><br>
    <select name="designation_id" required>
        <option value="">-- Select Designation --</option>
        <?php foreach ($designations as $des): ?>
            <option value="<?= $des->designation_id ?>" <?= (isset($user) && $user->designation_id == $des->designation_id) ? 'selected' : '' ?>>
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
                    designationSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading designations:', error);
            });
    });
    </script>

