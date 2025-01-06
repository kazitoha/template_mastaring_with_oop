<?php


class UserController
{
    private $db;

    public function __construct($db = null)
    {
        $this->db = $db ?: new Database();
    }

    // Fetch all users
    public function getUsers()
    {
        $query = 'SELECT * FROM `users`';
        return $this->db->select($query);
    }

    // Add a new user
    public function addUser($username, $email, $password)
    {
        $password = md5($password);
        $query = 'INSERT INTO `users` (`user_name`, `email`,`password`) VALUES (:username, :email,:password)';
        $params = [
            ':username' => $username,
            ':email' => $email,
            ':password' => $password,
        ];
        $insertedId = $this->db->insert($query, $params);

        if ($insertedId) {
            $_SESSION['s_msg'] = "Your data has been successfully added!";
            echo "<script>window.location.href='?page=user';</script>";
            exit;
        } else {
            $_SESSION['w_msg'] = "Failed to add user!";
            echo "<script>window.location.href='?page=user';</script>";
            exit;
        }
    }

    // Update a user's email
    public function updateUser($id, $email)
    {
        $query = 'UPDATE `users` SET `email` = :email WHERE `id` = :id';
        $params = [
            ':email' => $email,
            ':id' => $id,
        ];
        return $this->db->update($query, $params);
    }

    // Delete a user
    public function deleteUser($id)
    {
        $query = 'DELETE FROM `users` WHERE `id` = :id';
        $params = [
            ':id' => $id,
        ];
        return $this->db->delete($query, $params);
    }
}
