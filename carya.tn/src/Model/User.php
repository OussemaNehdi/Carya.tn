<?php
// Include necessary files
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php';

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

    // Method to get a user object from the sql result
    public static function getUserFromRow($row) {
        return new User(
            $row['id'],
            $row['firstName'],
            $row['lastName'],
            $row['password'],
            $row['email'],
            $row['creation_date'],
            $row['role']
        );
    }

    // Method to add a user
    public static function addUser($firstName, $lastName, $password, $email) {
        global $pdo;
        try {
            $sql = "INSERT INTO users (firstName, lastName, password, email) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$firstName, $lastName, $password, $email]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error adding user: " . $e->getMessage());
            throw $e;
        }
    }

    // Method to get all users
    public static function getAllUsers() {
        global $pdo;
        try {
            $sql = "SELECT * FROM users";
            $stmt = $pdo->query($sql);
            $users = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $user = User::getUserFromRow($row);
                $users[] = $user;
            }
            return $users;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error fetching all users: " . $e->getMessage());
            throw $e;
        }
    }

    // Method to delete a user by ID
    public static function deleteUserById($userId) {
        global $pdo;
        try {
            $sql = "DELETE FROM users WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$userId]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error deleting user by ID: " . $e->getMessage());
            throw $e;
        }
    }

    // Method to get a user by ID
    public static function getUserById($userId) {
        global $pdo;
        try {
            $sql = "SELECT * FROM users WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$userId]);
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($userData) {
                $user = User::getUserFromRow($userData);
                return $user;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error fetching user by ID: " . $e->getMessage());
            throw $e;
        }
    }

    // Method to ban a user by ID
    public function banUserById() {
        global $pdo;
        try {
            $sql = "UPDATE users SET role = 'banned' WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$this->id]);
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error banning user by ID: " . $e->getMessage());
            throw $e;
        }
    }

    // Method to unban a user by ID
    public function unbanUserById() {
        global $pdo;
        try {
            $sql = "UPDATE users SET role = 'customer' WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$this->id]);
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error unbanning user by ID: " . $e->getMessage());
            throw $e;
        }
    }

    // Method to display user actions
    public function displayUserActions() {
        if ($this->role == 'banned') {
            echo "<a href=\"http://localhost/Mini-PHP-Project/carya.tn/src/controllers/unban_user.php?id={$this->id}\">Unban</a>";
        } else if ($this->role == 'admin') {
            echo "Admin";
        } else {
            echo "<a href=\"http://localhost/Mini-PHP-Project/carya.tn/src/controllers/ban_user.php?id={$this->id}\">Ban</a>";
        }
    }

    // Method to get cars by owner ID
    public function getCarsByOwnerId() {
        global $pdo;
        try {
            $sql = "SELECT * FROM cars WHERE owner_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$this->id]);
            $cars = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $car = Car::getCarFromRow($row);
                $cars[] = $car;
            }
            return $cars;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error fetching cars by owner ID: " . $e->getMessage());
            throw $e;
        }
    }
}
?>
