<!-- app/Views/activities/task_history.php -->

<h3>Task Edit History</h3>

<p><strong>Current Task:</strong> <?= htmlspecialchars($task->task) ?></p>
<p><strong>Deliverable:</strong> <?= nl2br(htmlspecialchars($task->deliverable)) ?></p>

<?php if (empty($history)): ?>
    <p style="color: gray;">No edit history found for this task.</p>
<?php else: ?>
    <table border="1" cellpadding="8" cellspacing="0" style="width:100%; margin-top: 20px;">
        <thead style="background: #f2f2f2;">
            <tr>
                <th>Edited By</th>
                <th>Edited At</th>
                <th>Field</th>
                <th>Before</th>
                <th>After</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($history as $entry): ?>
                <?php
                    // Create before vs after pairs for each editable field
                    $fields = [
                        'Task Title' => [$entry->old_task_title, $task->task],
                        'Assignee ID' => [$entry->old_assignee_id, $task->assignee_id],
                        'Deliverable' => [$entry->old_deliverable, $task->deliverable],
                        'Resource' => [$entry->old_resource, $task->resource],
                        'Status' => [$entry->old_status, $task->status],
                        'Comment' => [$entry->old_comments, '-']
                    ];
                ?>
                <?php foreach ($fields as $label => [$before, $after]): ?>
                    <?php if ($before !== null && $before != $after): ?>
                        <tr>
                            <td><?= htmlspecialchars($entry->editor_name ?? 'Unknown') ?></td>
                            <td><?= date('Y-m-d H:i', strtotime($entry->edited_at)) ?></td>
                            <td><strong><?= $label ?></strong></td>
                            <td style="color: darkred;"><?= nl2br(htmlspecialchars($before)) ?></td>
                            <td style="color: darkgreen;"><?= nl2br(htmlspecialchars($after)) ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>


<br><br>
<p><a href="<?= $base_url ?>activities">← Back to Activities</a></p>
