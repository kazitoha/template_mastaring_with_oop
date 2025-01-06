<?php

class Database
{
    private $pdo;

    public function __construct($pdo = null)
    {
        $this->pdo = $pdo ?: self::getConnection();
    }

    // Singleton to get the PDO instance
    public static function getConnection()
    {
        static $instance = null;
        if ($instance === null) {
            $dsn = 'mysql:host=localhost;dbname=template_mastaring';
            $username = 'root';
            $password = '';
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];
            $instance = new PDO($dsn, $username, $password, $options);
        }
        return $instance;
    }

    // SELECT query
    public function select($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // INSERT query
    public function insert($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $this->pdo->lastInsertId();
    }

    // UPDATE query
    public function update($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($params);
    }

    // DELETE query
    public function delete($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($params);
    }
}
