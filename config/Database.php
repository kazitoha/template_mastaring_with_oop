<?php

class Database
{
    private $pdo;
    private $query;
    private $params = [];

    public function __construct($pdo = null)
    {
        $this->pdo = $pdo ?: self::getConnection();
        $this->query = '';
    }

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
    public function select($columns)
    {
        $this->query = "SELECT $columns";
        return $this;
    }

    // FROM query
    public function from($table)
    {
        $this->query .= " FROM `$table`";
        return $this;
    }

    // WHERE query
    public function where($condition, $params = [])
    {
        $this->query .= " WHERE $condition";
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    // ORDER BY query
    public function orderBy($column, $direction = 'ASC')
    {
        $this->query .= " ORDER BY `$column` $direction";
        return $this;
    }

    // LIMIT query
    public function limit($limit)
    {
        $this->query .= " LIMIT :limit";
        $this->params[':limit'] = $limit;
        return $this;
    }

    // OFFSET query
    public function offset($offset)
    {
        $this->query .= " OFFSET :offset";
        $this->params[':offset'] = $offset;
        return $this;
    }

    // Execute the query and return results
    public function get()
    {
        $stmt = $this->pdo->prepare($this->query);
        $stmt->execute($this->params);
        return $stmt->fetchAll();
    }

    // Generic execute method
    public function execute($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }
}
