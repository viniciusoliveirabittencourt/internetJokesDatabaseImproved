<?php
class DatabaseTable {
    private function processesDates($values) {
        foreach ($values as $key => $value) {
            if ($value instanceof DateTime) {
                $values[$key] = $value->format('Y-m-d');
            }
        }

        return $values;
}
    public function total($pdo, $table) {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM `' . $table . '`');
        $stmt->execute();
        $row = $stmt->fetch();
        return $row[0];
    }

    public function find($pdo, $table, $field, $value) {
        $query = 'SELECT * FROM `' . $table . '` WHERE `'. $field . '` = :value';
        $values = ['value' => $value];

        $stmt = $pdo->prepare($query);
        $stmt->execute($values);
        return $stmt->fetchAll();
    }

    private function insert($pdo, $table, $values) {
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

        $values = $this->processesDates($values);

        $stmt = $pdo->prepare($query);
        $stmt->execute($values);
    }

    private function update($pdo, $table, $primarykey, $values) {
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

        $values = $this->processesDates($values);

        $stmt = $pdo->prepare($query);
        $stmt->execute($values);
    }

    public function delete($pdo, $table, $field, $value) {
        $stmt = $pdo->prepare('DELETE FROM `' . $table . '` WHERE `' . $field . '` = :value');
        $stmt->execute(['value' => $value]);
    }

    public function save($pdo, $table, $primarykey, $record) {
        try {
            if (empty($record[$primarykey])) {
                unset($record[$primarykey]);
            }
            $this->insert($pdo, $table, $record);
        } catch (PDOException $e) {
            $this->update($pdo, $table, $primarykey, $record);
        }
    }
}
