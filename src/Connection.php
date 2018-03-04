<?php

namespace Cqrs;

use PDO;
use stdClass;

class Connection
{

    /**
     * @var PDO
     */
    private $connection;

    public function beginTransaction() : void
    {
       $this->connect()->beginTransaction();
    }

    public function commit() : void
    {
        $this->connect()->commit();
    }

    public function rollBack() : void
    {
        $this->connect()->rollBack();
    }

    public function migrate(string $file) : void
    {
        $this->connect()->exec(file_get_contents($file));
    }

    public function find(string $table, int $id) : stdClass
    {
        $statement = $this->connect()->prepare(
            sprintf(
                'SELECT * FROM %s WHERE id = ?',
                $table
            )
        );
        $statement->execute(
            [
                $id
            ]
        );

        return $statement->fetchObject();
    }

    public function insert(string $table, array $data) : void
    {
        $sql = sprintf(
            'INSERT INTO %s(%s) VALUES(%s)',
            $table,
            implode(', ', array_keys($data)),
            rtrim(str_repeat('?, ', count($data)), ', ')
        );

        $statement = $this->connect()->prepare($sql);
        $statement->execute(array_values($data));
    }

    public function update(string $table, array $data) : void
    {
        $sql = sprintf(
            'UPDATE %s %s WHERE id = %s',
            $table,
            $this->generateSets($data),
            $data['id']
        );

        $statement = $this->connect()->prepare($sql);
        $statement->execute(array_values($data));
    }

    private function generateSets(array $data) : string
    {
        $sets = [];

        foreach ($data as $field => $value) {
            if ($field == 'id') {
                continue;
            }

            $sets[] = sprintf(
                'SET %s = ?',
                $field
            );
        }

        return 'SET ' . implode(', ', $sets);
    }

    private function connect() : PDO
    {
        if ($this->connection) {
            return $this->connection;
        }

        $db = realpath(
            __DIR__ .
            DIRECTORY_SEPARATOR .
            '..' .
            DIRECTORY_SEPARATOR .
            'storage' .
            DIRECTORY_SEPARATOR .
            'db.sqlite'
        );

        return $this->connection = new PDO(
            "sqlite:$db",
            null,
            null,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }
}