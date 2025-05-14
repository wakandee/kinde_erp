<h2>View Activity</h2>

<p><strong>Title:</strong> <?= htmlspecialchars($activity->title) ?></p>
<p><strong>Date:</strong> <?= htmlspecialchars($activity->activity_date) ?></p>
<p><strong>Week:</strong> <?= htmlspecialchars($activity->week_number) ?></p>

<h3>Tasks</h3>
<ul>
    <?php foreach ($activity->tasks as $task): ?>
        <li>
            <strong><?= htmlspecialchars($task->task) ?></strong> - 
            <?= htmlspecialchars($task->status) ?> (<?= htmlspecialchars($task->assignee_name ?? 'N/A') ?>)
        </li>
    <?php endforeach; ?>
</ul>

<a href="<?= $base_url ?>activities">Back to Activities</a>
