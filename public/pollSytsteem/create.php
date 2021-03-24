<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

$answerV = 0;


if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Check if POST variable "title" exists, if not default the value to blank, basically the same for all variables
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $desc = isset($_POST['desc']) ? $_POST['desc'] : '';
    // Insert new record into the "polls" table
    $stmt = $pdo->prepare('INSERT INTO polls VALUES (NULL, ?, ?)');
    $stmt->execute([$title, $desc]);
    // Below will get the last insert ID, this will be the poll id
    $poll_id = $pdo->lastInsertId();


    // Get the question
    $question = isset($_POST['question']) ? $_POST['question'] : '';
    // Sends it to the DB
    $stmt = $pdo->prepare('INSERT INTO poll_questions VALUE (NULL,?,?)');
    $stmt->execute([$poll_id, $question]);
    // Gets the primary key to tie it to the answers
    $poll_questions_id = $pdo->lastInsertId();
    // Get the answers and convert the multiline string to an array, so we can add each answer to the "poll_answers" table
    $answers = isset($_POST['answers']) ? explode(PHP_EOL, $_POST['answers']) : '';
    foreach ($answers as $answer) {
        // If the answer is empty there is no need to insert
        if (empty($answer)) continue;
        // Add answer to the "poll_answers" table
        $stmt = $pdo->prepare('INSERT INTO poll_answers VALUES (NULL, ?, ? ,0,?)');
        $stmt->execute([$poll_id, $answer, $poll_questions_id]);
    }
    // Output message
    $msg = 'Created Successfully!';

}
?>

<?= template_header('Create Poll') ?>
<script>

</script>

<section class="centered">
    <div>
        <h1 class="header">Create Poll</h1>
    </div>
</section>

<section class="centered">
    <form action="create.php" method="post" class="form">
        <label class="createLabel" for="title">Titel</label>
        <input class="createInput" type="text" name="title" id="title">

        <label class="createLabel" for="desc">Beschrijving</label>
        <input class="createInput" type="text" name="desc" id="desc">

        <label class="createLabel" for="question">Vraag</label>
        <input class="createInput" type="text" name="question" id="question">

        <label class="createLabel" for="answers">Antwoorden (1 antwoord per zin)</label>
        <textarea class="createInput" name="answers" id="answers" required></textarea>

        <input type="submit" value="Create" class="btn">
    </form>
</section>

<?php if ($msg): ?>
    <p class="centered succes"><?= $msg ?></p>
<?php endif; ?>
</div>


<?= template_footer() ?>
