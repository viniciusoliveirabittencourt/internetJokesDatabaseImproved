<?php
function allJokes($pdo) {
    $stmt = $pdo->prepare('SELECT `joke`.`id`, `joketext`, `jokedate`, `name`, `email` FROM `joke` INNER JOIN `author` ON `authorid` = `author`.`id`;');
    $stmt->execute();
    return $stmt->fetchAll();
}

function insert($pdo, $table, $values) {
    $query = 'INSERT INTO `' . $table . '` (';

    foreach ($values as $key => $value) {
        if ($value instanceof DateTime) {
            $values[$key] = $value->format('Y-m-d');
        }
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
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM `' . $table . '`');
    $stmt->execute();
    $row = $stmt->fetch();
    return $row[0];
}

function save($pdo, $table, $primarykey, $record) {
    try {
        if (empty($record[$primarykey])) {
            unset($record[$primarykey]);
        }
        insert($pdo, $table, $record);
    } catch (PDOException $e) {
        update($pdo, $table, $primarykey, $record);
    }
}