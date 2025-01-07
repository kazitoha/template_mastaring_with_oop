<?php
class Model
{
    protected $table;
    protected $primaryKey = 'id';
    protected $attributes = [];
    protected $db;

    public function __construct($db = null)
    {
        $this->db = $db ?: new Database();
    }

    // public function __construct()
    // {
    //     $this->db = Database::getInstance();
    // }

    // Mass-assignment: Set attributes on the model
    public function fill(array $data)
    {
        $this->attributes = $data;
    }

    // Get all rows
    public function all()
    {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Find a single record by primary key
    public function find($id)
    {
        $query = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insert a new record
    public function create(array $data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $query = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }

    // Update an existing record
    public function update($id, array $data)
    {
        $setClause = '';
        foreach ($data as $key => $value) {
            $setClause .= "{$key} = :{$key}, ";
        }
        $setClause = rtrim($setClause, ', ');

        $query = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->prepare($query);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    // Delete a record
    public function delete($id)
    {
        $query = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }
}
