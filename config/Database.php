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
        $this->query .= " FROM $table"; // Ensure this is added
        return $this;
    }

    // LIMIT query
    public function limit($limit)
    {
        $this->query .= " LIMIT $limit";
        return $this;
    }

    // OFFSET query
    public function offset($offset)
    {
        $this->query .= " OFFSET $offset";
        return $this;
    }

    // ORDER BY query
    public function orderBy($column, $direction = 'ASC')
    {
        $this->query .= " ORDER BY $column $direction";
        return $this;
    }

    // Prepare the query and execute
    public function get()
    {
        if (strpos($this->query, 'ORDER BY') !== false && strpos($this->query, 'LIMIT') !== false) {
            // Move ORDER BY before LIMIT if necessary
            $this->query = preg_replace('/(ORDER BY.*)(LIMIT.*)/', '$1 $2', $this->query);
        }

        $stmt = $this->pdo->prepare($this->query);
        $stmt->execute($this->params);
        return $stmt->fetchAll();
    }

    // Execute a query with parameters
    public function execute($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }
}
