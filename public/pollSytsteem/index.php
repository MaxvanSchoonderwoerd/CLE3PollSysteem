<?php
include 'functions.php';
//Connect to MySQL
$pdo = pdo_connect_mysql();
//MySQL query that selects all the polls and poll answers
$stmt = $pdo->query('SELECT p.*, GROUP_CONCAT(pa.title ORDER BY pa.id) AS answers FROM polls p LEFT JOIN poll_answers pa ON pa.poll_id = p.id GROUP BY p.id');
$polls = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= template_header('Polls') ?>

    <section class="centered">
        <h1 class="header">Polls</h1>
        <h1 class="createLabel">Welkom bij I-theater.</h1>
    </section>

    <section class="centered">
        <table>
            <tbody class="table">
            <?php foreach ($polls as $poll): ?>
                <tr class="tableRow">
                    <td><?= $poll['title'] ?></td>
                    <td class="icon">
                        <a href="vote.php?id=<?= $poll['id'] ?>" class="view" title="View Poll"><i
                                    class="fas fa-eye fa-xs"></i></a>
                        <a href="delete.php?id=<?= $poll['id'] ?>" class="trash" title="Delete Poll"><i
                                    class="fas fa-trash fa-xs"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>

</div>

<?= template_footer() ?>
