<h2>Task Comment History</h2>

<p><strong>Task:</strong> <?= htmlspecialchars($task->task) ?></p>

<table border="1" cellpadding="6">
    <thead>
        <tr>
            <th>Date</th>
            <th>Status</th>
            <th>Comment</th>
            <th>By</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($updates as $update): ?>
            <tr>
                <td><?= date('Y-m-d H:i', strtotime($update->created_at)) ?></td>
                <td><?= htmlspecialchars($update->status) ?></td>
                <td><?= nl2br(htmlspecialchars($update->comment)) ?></td>
                <td><?= htmlspecialchars($update->user_name ?? 'Unknown') ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="<?= $base_url ?>activities">Back to Activities</a>
