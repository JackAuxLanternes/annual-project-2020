<?php

class DatabaseManager {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=perfect_concierge;port=3306',
            'root',
            '9bVc4WT9q24y',
            array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    }

    /**
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function exec(string $sql, array $params = []): int {
        $statement = $this->internalExec($sql, $params);
        if($statement === null) {
            return 0;
        }
        return $statement->rowCount();
    }

    public function internalExec(string $sql, array $params): ?PDOStatement {
        $statement = $this->pdo->prepare($sql);
        if($statement === false) {
            return null;
        }
        $res = $statement->execute($params);
        if($res === false) {
            return null;
        }
        return $statement;
    }

    public function find(string $sql, array $params = []): ?array {
        $statement = $this->internalExec($sql, $params);
        if($statement === null) {
            return null;
        }
        $line = $statement->fetch(PDO::FETCH_ASSOC);
        if($line === false) {
            return null;
        }
        return $line;
    }

    public function exists(string $param): bool{
        $found = $this->find('SELECT id FROM user WHERE email = ?', [$param]);
        return $found !== null;
    }

    /**
     * @return string A randomly generated ID with minimum chance of duplicate
     */

    public static function uuid() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}