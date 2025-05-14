<h2>Update Task Status</h2>

<form method="POST" action="<?= $base_url ?>activities/update_status/<?= $task->task_id ?>">
    <p><strong>Task:</strong> <?= htmlspecialchars($task->task) ?></p>

    <label for="status">Status:</label>
    <select name="status" id="status" required onchange="handleStatusChange(this.value)">
        <?php foreach ($statusOptions as $option): ?>
            <option value="<?= $option ?>" <?= $task->status === $option ? 'selected' : '' ?>>
                <?= $option ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <div id="commentSection">
        <label for="comment">Comment:</label>
        <textarea name="comment" id="comment" rows="3" required></textarea>
    </div>

    <br>
    <button type="submit">Update Status</button>
</form>

<script>
function handleStatusChange(status) {
    const commentBox = document.getElementById('comment');
    const section = document.getElementById('commentSection');
    if (status === 'Done') {
        commentBox.required = false;
        section.style.display = 'none';
    } else {
        commentBox.required = true;
        section.style.display = 'block';
    }
}
window.onload = () => handleStatusChange(document.getElementById('status').value);
</script>
