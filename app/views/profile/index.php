	<h2>My Profile</h2>

<p><strong>Name:</strong> <?= htmlspecialchars($user->name); ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($user->email); ?></p>
<p><strong>Username:</strong> <?= htmlspecialchars($user->username); ?></p>
<p><strong>Phone Number:</strong> <?= htmlspecialchars($user->phone_number ?? 'N/A'); ?></p>
<p><strong>Department:</strong> <?= htmlspecialchars($user->department_name ?? 'Not assigned'); ?></p>
<p><strong>Designation:</strong> <?= htmlspecialchars($user->designation_name ?? 'Not assigned'); ?></p>
