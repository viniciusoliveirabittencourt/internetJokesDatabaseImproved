<?php
try {
    include __DIR__ . '/../includes/DatabaseConnection.php';
    $sql = 'DELETE FROM `joke` WHERE `id` = :jokeId';

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':jokeId', $_POST['jokeId']);
    $stmt->execute();

    header('Location: jokes.php');
} catch (PDOException $e) {
    $title = 'An error has occurred';

    $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();

    include __DIR__ . '/../templates/layout.html.php';
}