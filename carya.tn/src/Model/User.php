<?php

include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php'; // Include the file with database connection

class User {
    // Properties
    public $id;
    public $firstName;
    public $lastName;
    public $password;
    public $email;
    public $creation_date;
    public $role;

    // Constructor
    public function __construct($id, $firstName, $lastName, $password, $email, $creation_date, $role) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
        $this->email = $email;
        $this->creation_date = $creation_date;
        $this->role = $role;
    }

    // Method to get full name
    public function getFullName() {
        return $this->firstName . ' ' . $this->lastName;
    }

    // Method to get all users
    public static function getAllUsers() {
        global $pdo; // Use the database connection from connect.php
        $sql = "SELECT * FROM users";
        $stmt = $pdo->query($sql);
        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = $row; // Store each row as an associative array
        }
        return $users;
    }


    // Method to delete a user by ID
    public static function deleteUserById($userId) {
        global $pdo; // Use the database connection from connect.php
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        // Check if any rows were affected (user deleted)
        return $stmt->rowCount() > 0;
    }

}

?>
