<?php
class UserController
{
    private $db;

    public function __construct($db = null)
    {
        // Injecting Database instance or creating one if not passed
        $this->db = $db ?: new Database();
    }

    // Fetch all users with pagination
    public function getUsers($page = 1, $limit = 10)
    {
        // Ensure $page is an integer
        $page = (int)$page;
        // If $page is less than 1, set it to 1 (to prevent negative or zero pages)
        if ($page < 1) {
            $page = 1;
        }
        // Calculate the offset for pagination
        $offset = ($page - 1) * $limit;

        // Build the query with method chaining
        $query = (new Database())
            ->select('id, user_name, email')
            ->from('users')
            ->orderBy('user_name', 'ASC')
            ->limit(limit: $limit)
            ->offset($offset) // Pagination offset
            ->get();

        return $query; // Return results directly
    }



    // Add a new user
    public function addUser($username, $email, $password)
    {
        // Hash the password securely
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert query using placeholders
        $query = 'INSERT INTO `users` (`user_name`, `email`, `password`) VALUES (:username, :email, :password)';
        $params = [
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword,
        ];

        // Insert user into database
        $insertedId = $this->db->insert($query, $params);

        if ($insertedId) {
            $_SESSION['s_msg'] = "User has been successfully added!";
            header("Location: ?page=user"); // Use header for redirect
            exit;
        } else {
            $_SESSION['w_msg'] = "Failed to add user!";
            header("Location: ?page=user"); // Use header for redirect
            exit;
        }
    }

    // Update a user's email
    public function updateUser($id, $email)
    {
        // Update query for changing user's email
        $query = 'UPDATE `users` SET `email` = :email WHERE `id` = :id';
        $params = [
            ':email' => $email,
            ':id' => $id,
        ];
        // Return update result (success/failure)
        return $this->db->update($query, $params);
    }

    // Delete a user
    public function deleteUser($id)
    {
        // Delete query to remove user by ID
        $query = 'DELETE FROM `users` WHERE `id` = :id';
        $params = [
            ':id' => $id,
        ];
        // Execute deletion and return result
        return $this->db->delete($query, $params);
    }
}
