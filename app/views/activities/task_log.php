<h3>Activity Log</h3>
<ul>
    <?php foreach ($updates as $update): ?>
        <li>
            <strong><?= $update->status ?></strong>
            by <?= $update->user_name ?> 
            on <?= date('M d, Y H:i', strtotime($update->created_at)) ?> —
            <?= nl2br(htmlspecialchars($update->comment)) ?>
        </li>
    <?php endforeach; ?>
</ul>
