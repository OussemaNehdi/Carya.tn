<?php
// This PHP file defines a class 'User' and related methods to manage user data in a database.

// Include necessary files
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php';

/**
 * Represents a user object with properties and methods to manage user data in a database.
 */
class User {
    /**
     * The ID of the user.
     *
     * @var int
     */
    public $id;

    /**
     * The first name of the user.
     *
     * @var string
     */
    public $firstName;

    /**
     * The last name of the user.
     *
     * @var string
     */
    public $lastName;

    /**
     * The password of the user.
     *
     * @var string
     */
    public $password;

    /**
     * The email address of the user.
     *
     * @var string
     */
    public $email;

    /**
     * The date when the user account was created.
     *
     * @var string
     *      */
    public $creation_date;

    /**
     * The role of the user (e.g., admin, customer, banned).
     *
     * @var string
     */
    public $role;

    /**
     * The country of the user.
     *
     * @var string
     */
    public $country;

    /**
     * The state of the user.
     *
     * @var string
     */
    public $state;

    /**
     * The profile image URL of the user.
     *
     * @var string
     */
    public $profile_image;

    /**
     * Constructor to initialize a User object.
     *
     * @param int $id The ID of the user.
     * @param string $firstName The first name of the user.
     * @param string $lastName The last name of the user.
     * @param string $password The password of the user.
     * @param string $email The email address of the user.
     * @param string $creation_date The date when the user account was created.
     * @param string $role The role of the user.
     * @param string $country The country of the user.
     * @param string $state The state of the user.
     * @param string|null $profile_image The profile image of the user (optional).
     */
    public function __construct($id, $firstName, $lastName, $password, $email, $creation_date, $role, $country, $state, $profile_image = null) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
        $this->email = $email;
        $this->creation_date = $creation_date;
        $this->role = $role;
        $this->country = $country;
        $this->state = $state;
        $this->profile_image = $profile_image;
    }

    /**
     * Method to create a User object from a database row.
     *
     * @param array $row The associative array representing a row fetched from the database.
     * @return User The User object created from the database row.
     */
    public static function getUserFromRow($row) {
        return new User(
            $row['id'],
            $row['firstName'],
            $row['lastName'],
            $row['password'],
            $row['email'],
            $row['creation_date'],
            $row['role'],
            $row['country'],
            $row['state'],
            $row['profile_image']
        );
    }

    /**
     * Method to add a new user to the database.
     *
     * @param string $firstName The first name of the user.
     * @param string $lastName The last name of the user.
     * @param string $password The password of the user.
     * @param string $email The email address of the user.
     * @param string $role The role of the user.
     * @return bool True if the user was successfully added, false otherwise.
     * @throws PDOException If an error occurs during the database operation.
     */
    public static function addUser($firstName, $lastName, $password, $email, $role) {
        global $pdo;
        try {
            $sql = "INSERT INTO users (firstName, lastName, password, email, role) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$firstName, $lastName, $password, $email, $role]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error adding user: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Method to retrieve all users from the database.
     *
     * @return array An array of User objects representing all users in the database.
     * @throws PDOException If an error occurs during the database operation.
     */
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

    /**
     * Method to delete a user from the database by ID.
     *
     * @param int $userId The ID of the user to delete.
     * @return bool True if the user was successfully deleted, false otherwise.
     * @throws PDOException If an error occurs during the database operation.
     */
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

    /**
     * Method to retrieve a user from the database by ID.
     *
     * @param int $userId The ID of the user to retrieve.
     * @return User|null The User object representing the user with the specified ID, or null if not found.
     * @throws PDOException If an error occurs during the database operation.
     */
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

    /**
     * Method to retrieve a user from the database by email address.
     *
     * @param string $email The email address of the user to retrieve.
     * @return User|null The User object representing the user with the specified email, or null if not found.
     * @throws PDOException If an error occurs during the database operation.
     */
    public static function getUserByEmail($email) {
        global $pdo;
        try {
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email]);
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($userData) {
                $user = User::getUserFromRow($userData);
                return $user;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error fetching user by email: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Method to ban a user from the system by ID.
     *
     * @return void
     * @throws PDOException If an error occurs during the database operation.
     */
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

    /**
     * Method to unban a user in the system by ID.
     *
     * @return void
     * @throws PDOException If an error occurs during the database operation.
     */
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

    /**
     * Method to display actions for a user based on their role.
     *
     * This method generates HTML links to perform user actions such as banning or unbanning.
     * If the user is banned, it displays a link to unban them.
     * If the user is an admin, it displays "Admin".
     * If the user is not banned or an admin, it displays a link to ban them.
     *
     * @return void
     */
    public function displayUserActions() {
        if ($this->role == 'banned') {
            echo "<a href=\"http://localhost/Mini-PHP-Project/carya.tn/src/controllers/unban_user.php?id={$this->id}\">Unban</a>";
        } else if ($this->role == 'admin') {
            echo "Admin";
        } else {
            echo "<a href=\"http://localhost/Mini-PHP-Project/carya.tn/src/controllers/ban_user.php?id={$this->id}\">Ban</a>";
        }
    }

    /**
     * Method to retrieve cars owned by the user from the database.
     *
     * @param array|null $filter An optional filter to apply to the cars (e.g., ['brand' => 'Toyota', 'year' => 2020]).
     * @return array An array of Car objects representing cars owned by the user.
     * @throws PDOException If an error occurs during the database operation.
     */
    public function getCarsByOwnerId($filter = null) {
        global $pdo;
        try {
            if ($filter) {
                $filter = Car::constructFilterQuery($filter);
                $cars = Car::getFilteredCars($filter, $this->id);
                return $cars;
            } else {
                $sql = "SELECT * FROM cars WHERE owner_id = ?";
            }
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

    /**
     * Method to update a user's first name in the database by ID.
     *
     * @param int $userId The ID of the user whose first name is to be updated.
     * @param string $firstName The new first name for the user.
     * @return bool True if the update operation was successful, false otherwise.
     * @throws PDOException If an error occurs during the database operation.
     */
    public static function updateFirstNameById($userId, $firstName) {
        global $pdo;
        try {
            $sql = "UPDATE users SET firstName = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$firstName, $userId]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error updating user's first name by ID: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Method to update a user's last name in the database by ID.
     *
     * @param int $userId The ID of the user whose last name is to be updated.
     * @param string $lastName The new last name for the user.
     * @return bool True if the update operation was successful, false otherwise.
     * @throws PDOException If an error occurs during the database operation.
     */
    public static function updateLastNameById($userId, $lastName) {
        global $pdo;
        try {
            $sql = "UPDATE users SET lastName = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$lastName, $userId]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error updating user's last name by ID: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Method to update a user's email address in the database by ID.
     *
     * @param int $userId The ID of the user whose email address is to be updated.
     * @param string $email The new email address for the user.
     * @return bool True if the update operation was successful, false otherwise.
     * @throws PDOException If an error occurs during the database operation.
     */
    public static function updateEmailById($userId, $email) {
        global $pdo;
        try {
            $sql = "UPDATE users SET email = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email, $userId]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error updating user's email by ID: " . $e->getMessage());
            throw $e;
        }
    }


    /**
     * Method to update a user's country and state in the database by ID.
     *
     * @param int $userId The ID of the user whose location is to be updated.
     * @param string $country The new country for the user.
     * @param string $state The new state for the user.
     * @return bool True if the update operation was successful, false otherwise.
     * @throws PDOException If an error occurs during the database operation.
     */
    public static function updateUserLocationById($userId, $country, $state) {
        global $pdo;
        try {
            $sql = "UPDATE users SET country = ?, state = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$country, $state, $userId]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error updating user's country and state by ID: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Method to update a user's profile image in the database by ID.
     *
     * @param string $profileImage The new profile image for the user.
     * @return bool True if the update operation was successful, false otherwise.
     * @throws PDOException If an error occurs during the database operation.
     */
    public function updateProfileImageById($profileImage) {
        global $pdo;
        try {
            $sql = "UPDATE users SET profile_image = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$profileImage, $this->id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error updating user's profile image by ID: " . $e->getMessage());
            throw $e;
        }
    }
}
?>
