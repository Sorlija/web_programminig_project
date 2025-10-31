<?php
require_once 'BaseDao.php';

class UsersDao extends BaseDao {

    public function __construct() {
        parent::__construct('users'); // table name
    }

    /* Get a user by email */
    public function getByEmail($email) {
        $sql = "SELECT * FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* Get all customers */
    public function getAllCustomers() {
        $sql = "SELECT * FROM " . $this->table . " WHERE role = 'customer'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* Check if a user exists by email*/
    public function existsByEmail($email) {
        $sql = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    /*Create a new user*/
    public function createUser($name, $email, $password, $role = 'customer') {
        $sql = "INSERT INTO " . $this->table . " (name, email, password, role) 
                VALUES (:name, :email, :password, :role)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role
        ]);
    }

    /*Update a user by ID*/
    public function updateUser($id, $data) {
        $fields = "";
        foreach ($data as $key => $value) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ", ");
        $sql = "UPDATE " . $this->table . " SET $fields WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    /*Delete a user by ID*/
    public function deleteUser($id) {
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
