<?php use App\Helpers\SessionHelper; ?>

<h3>My Daily Weekly Tracker</h3>
<hr><wbr>
<a href="<?= $base_url ?>activities/create">Add New Activity</a><br><br>

<?php if (!empty($tasks)): ?>
    <table border="1" cellpadding="6" style="width: 100%;">
        <thead>
            <tr>
                <th>Date</th>
                <th>Week</th>
                <th>Title</th>
                <th>Task</th>
                <th>Status</th>
                <th>Assignee</th>
                <th>Latest Comment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task):
            //var_dump($task); echo "<br><br>"; ?>
                <tr>
                    <td><?= date('D d-m', strtotime($task->activity_date)) ?></td>
                    <td><?= htmlspecialchars($task->week_number) ?></td>
                    <td><?= htmlspecialchars($task->activity_title) ?></td>
                    <td>
                        <strong><?= htmlspecialchars($task->task) ?></strong>
                        <?php if (!empty($task->is_edited)): ?>
                            <a href="<?= $base_url ?>activities/tasks/<?= $task->task_id ?>/history"
                               title="View edit history"
                               style="color: orange; text-decoration: none;"
                               onmouseover="showTooltip(this, '<?= htmlspecialchars($task->old_task ?? 'Original task not loaded') ?>')"
                               onmouseout="hideTooltip(this)">
                                [Edited]
                            </a>
                        <?php endif; ?>
                    </td>

                    <td><?= htmlspecialchars($task->status) ?></td>
                    <td><?= htmlspecialchars($task->assignee_name ?? 'N/A') ?></td>
                    <td>
                        <?php
                            $latest = $latestComments[$task->task_id] ?? null;
                            if ($latest):
                        ?>
                            <div><em>“<?= htmlspecialchars(mb_strimwidth($latest, 0, 50, "...")) ?>”</em></div>
                            <div><a href="<?= $base_url ?>activities/tasks/<?= $task->task_id ?>/comments">View All Comments</a></div>
                        <?php else: ?>
                            <span>No updates</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= $base_url ?>activities/tasks/<?= $task->task_id ?>/edit">Edit</a> |
                        <a href="<?= $base_url ?>activities/update_status/<?= $task->task_id ?>">Update Status</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No activities found for the current week.</p>
<?php endif; ?>

<script>
function showTooltip(el, text) {
    const tooltip = document.createElement('div');
    tooltip.className = 'tooltip';
    tooltip.textContent = "Before: " + text;
    tooltip.style.position = 'absolute';
    tooltip.style.backgroundColor = '#fff8dc';
    tooltip.style.border = '1px solid #ccc';
    tooltip.style.padding = '4px 8px';
    tooltip.style.fontSize = '0.85em';
    tooltip.style.color = '#333';
    tooltip.style.boxShadow = '0px 0px 4px rgba(0,0,0,0.2)';
    tooltip.style.zIndex = '999';
    el._tooltip = tooltip;
    document.body.appendChild(tooltip);

    const rect = el.getBoundingClientRect();
    tooltip.style.left = `${rect.left + window.scrollX + 10}px`;
    tooltip.style.top = `${rect.top + window.scrollY + 20}px`;
}

function hideTooltip(el) {
    if (el._tooltip) {
        document.body.removeChild(el._tooltip);
        el._tooltip = null;
    }
}
</script>

