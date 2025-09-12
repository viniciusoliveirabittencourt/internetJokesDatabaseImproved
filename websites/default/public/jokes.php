<?php
try {
    include __DIR__ . '/../includes/DatabaseConnection.php';
    include __DIR__ . '/../includes/DatabaseFunctions.php';

    $title = 'Joke List';
    $totalJokes = total($pdo, 'joke');
    $jokes = allJokes($pdo); // I will not refactor this function because of N+1 problem

    ob_start();
    include __DIR__ . '/../templates/jokes.html.php';

    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'An error has occured';
    $output = 'Database Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
}

include __DIR__ . '/../templates/layout.html.php';