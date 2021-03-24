<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the poll ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$poll) {
        die ('Poll doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM polls WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            // We also need to delete the answers for that poll
            $stmt = $pdo->prepare('DELETE FROM poll_answers WHERE poll_id = ?');
            $stmt->execute([$_GET['id']]);
            // Delete the questions from the poll
            $stmt = $pdo->prepare('DELETE FROM poll_questions WHERE poll_id = ?');
            $stmt->execute([$_GET['id']]);
            // Output msg
            $msg = 'You have deleted the poll!';
            header('Location: index.php');
            exit;
        } else {
            // User clicked the "No" button, redirect them back to the home/index page
            header('Location: index.php');
            exit;
        }
    }
} else {
    die ('No ID specified!');
}
?>

<?= template_header('Delete') ?>

<section class="centered">
    <h2 class="header">Delete polls</h2>
</section>

<div class="centered">
    <section class="centered"></section>
    <?php if ($msg): ?>
        <p><?= $msg ?></p>
    <?php else: ?>
        <p>Are you sure you want to delete poll "<?= $poll['title'] ?>"?</p>
        <br>
        <a class="deleteBtn redText" href="delete.php?id=<?= $poll['id'] ?>&confirm=yes">Yes</a>
        <a class="deleteBtn greenText" href="delete.php?id=<?= $poll['id'] ?>&confirm=no">No</a>
    <?php endif; ?>

</div>


<?= template_footer() ?>
