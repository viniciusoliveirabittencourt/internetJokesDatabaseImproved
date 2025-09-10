<?php
try {
    $pdo = new PDO('mysql:host=mysql;dbname=ijdb;charset=utf8mb4', 'ijdbuser', 'mypassword');
    $sql = 'SELECT `joke`.`id`, `joketext`, `name`, `email` FROM `joke` INNER JOIN `author` ON `authorid` = `author`.`id`;';
    $title = 'Joke List';

    $jokes = $pdo->query($sql);

    ob_start();
    include __DIR__ . '/../templates/jokes.html.php';

    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'An error has occured';
    $output = 'Database Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
}

include __DIR__ . '/../templates/layout.html.php';