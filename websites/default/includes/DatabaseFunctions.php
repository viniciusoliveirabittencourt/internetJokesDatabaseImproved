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

function insertJoke($pdo, $values) {
    $query = 'INSERT INTO `joke` (';

    foreach ($values as $key => $value) {
        if($value instanceof DateTime) {
            $values[$key] = $value->format('Y-m-d');
        }
        $query .= '`' . $key . '`,'; // INSERT INTO `joke` (`authorid`, `jokedate`, `joketext`,
    }
    $query = rtrim($query, ','); // INSERT INTO `joke` (`authorid`, `jokedate`, `joketext`

    $query .= ') VALUES ('; // INSERT INTO `joke` (`authorid`, `jokedate`, `joketext`) VALUES (

    foreach ($values as $key => $value) {
        $query .= ':' . $key . ','; // INSERT INTO `joke` (`authorid`, `jokedate`, `joketext`) VALUES (:authorid, :jokedate, :joketext,
    }
    $query = rtrim($query, ','); // INSERT INTO `joke` (`authorid`, `jokedate`, `joketext`) VALUES (:authorid, :jokedate, :joketext

    $query .= ')';

    $stmt = $pdo->prepare($query);
    $stmt->execute($values);
}

function updateJoke($pdo, $values) {
    $query = 'UPDATE `joke` SET ';
    $updateFields = [];

    foreach ($values as $key => $value) {
        if ($value instanceof DateTime) {
            $values[$key] = $value->format('Y-m-d');
        }
        $updateFields[] = '`' . $key . '` = :' . $key;
    }
    $query .= implode(', ', $updateFields);
    $query .= ' WHERE `id` = :primarykey';
    $values['primarykey'] = $values['id'];

    $stmt = $pdo->prepare($query);
    $stmt->execute($values);
}

function deleteJoke($pdo, $id) {
    $stmt = $pdo->prepare('DELETE FROM `joke` WHERE `id` = :id');
    $stmt->execute([':id' => $id]);
}

function allJokes($pdo) {
    $stmt = $pdo->prepare('SELECT `joke`.`id`, `joketext`, `jokedate`, `name`, `email` FROM `joke` INNER JOIN `author` ON `authorid` = `author`.`id`;');
    $stmt->execute();
    return $stmt->fetchAll();
}

function allAuthors($pdo) {
    $stmt = $pdo->prepare('SELECT * FROM `author`');
    $stmt->execute();
    return $stmt->fetchAll();
}

function deleteAuthor($pdo, $id) {
    $values = [':id' => $id];
    $stmt = $pdo->prepare('DELETE FROM `author` WHERE `id` = :id');
    $stmt->execute($values);
}

function insertAuthor($pdo, $values) {
    $query = 'INSERT INTO `author` (';

    foreach ($values as $key => $value) {
        $query .= '`' . $key . '`,';
    }
    $query = rtrim($query, ',');


    $query .= ') VALUES (';

    foreach ($values as $key => $value) {
        $query .= ':' . $key . ',';
    }
    $query = rtrim($query, ',');

    $query .= ')';

    $stmt = $pdo->prepare($query);
    $stmt->execute($values);
}

function delete($pdo, $table, $field, $value) {
    $values = [':value' => $value];
    $stmt = $pdo->prepare('DELETE FROM `' . $table . '` WHERE `'. $field .'` = :value');
    $stmt->execute($values);
}

function findAll($pdo, $table) {
    $stmt = $pdo->prepare('SELECT * FROM `' . $table . '`');
    $stmt->execute();

    return $stmt->fetchAll();
}

function insert($pdo, $table, $values) {
    $query = 'INSERT INTO `' . $table . '` (';

    foreach ($values as $key => $value) {
        $query .= '`' . $key . '`,';
    }
    $query = rtrim($query, ',');


    $query .= ') VALUES (';

    foreach ($values as $key => $value) {
        $query .= ':' . $key . ',';
    }
    $query = rtrim($query, ',');

    $query .= ')';

    $stmt = $pdo->prepare($query);
    $stmt->execute($values);
}

function update($pdo, $table, $primarykey, $values) {
    $query = 'UPDATE ' . $table . ' SET ';
    $updateFields = [];

    foreach ($values as $key => $value) {
        if ($value instanceof DateTime) {
            $values[$key] = $value->format('Y-m-d');
        }
        $updateFields[] = '`' . $key . '` = :' . $key;
    }
    $query .= implode(', ', $updateFields);
    $query .= ' WHERE `' . $primarykey . '` = :primarykey';
    $values['primarykey'] = $values['id'];

    $stmt = $pdo->prepare($query);
    $stmt->execute($values);
}

function find($pdo, $table, $field, $value) {
    $query = 'SELECT * FROM `' . $table . '` WHERE `'. $field . '` = :value';
    $values = ['value' => $value];

    $stmt = $pdo->prepare($query);
    $stmt->execute($values);
    return $stmt->fetchAll();
}

function total($pdo, $table) {
    $stmt = $pdo->prepate('SELECT COUNT(*) FROM `' . $table . '`');
    $stmt->execute();
    $row = $stmt->fetch();
    return $row[0];
}