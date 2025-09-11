<?php
function totaljokes($pdo) {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM `joke`');
    $stmt->execute();

    $row = $stmt->fetch();

    return $row[0];
};

function getJoke($pdo, $id) {
    $stmt = $pdo->prepare('SELECT * FROM `joke` WHERE `id` = :id');
    $stmt->execute([':id' => $id]);

    return $stmt->fetch();
}

function insertJoke($pdo, $joketext, $authorid) {
    $stmt = $pdo->prepare('INSERT INTO `joke` (`joketext`, `jokedate`, `authorid`) VALUES (:joketext, :jokedate, :authorid)');
    $values = [':joketext' => $joketext, ':authorid' => $authorid, ':jokedate' => date('Y-m-d')];

    $stmt->execute($values);
}

function updateJoke($pdo, $jokeId, $jokeText, $authorId) {
    $stmt = $pdo->prepare('UPDATE `joke` SET `authorid` = :authorId, `joketext` = :jokeText WHERE `id` = :id');
    $values = ['id' => $jokeId, 'jokeText' => $jokeText, 'authorId' => $authorId];

    $stmt->execute($values);
}

function deleteJoke($pdo, $id) {
    $stmt = $pdo->prepare('DELETE FROM `joke` WHERE `id` = :id');
    $stmt->execute([':id' => $id]);
}

function allJokes($pdo) {
    $stmt = $pdo->prepare('SELECT `joke`.`id`, `joketext`, `name`, `email` FROM `joke` INNER JOIN `author` ON `authorid` = `author`.`id`;');
    $stmt->execute();
    return $stmt->fetchAll();
}