<?php
// Check if the session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $customer = $_POST['check1'];

    $role = $customer;

    if (isset($first_name, $last_name, $email, $password)) {

        // Sanitize the email
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $email = trim($email);

        // Check if the email exists
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$email]);
        } catch (PDOException $e) {
            echo "Error executing query: " . $e->getMessage();
            exit();
        }
        $stmt->execute([$email]);

        $result = $stmt->fetch();
        if ($result) {
            header('Location: http://localhost/Mini-PHP-Project/HTML/login.php?message=User already exists&slide=register');
            exit();
        }

        // Validate the password
        if (strlen($password) < 8) {
            header('Location: http://localhost/Mini-PHP-Project/HTML/login.php?message=Password must be at least 8 characters&slide=register');
            exit();
        } else {
            $password = trim($password);
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user into the database
        $sql = "INSERT INTO users (firstName, lastName, email, password, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        if ($stmt) {
            if ($stmt->execute([$first_name, $last_name, $email, $hashed_password, $role])) {
                header('Location: http://localhost/Mini-PHP-Project/HTML/login.php?message=Account created successfully');
                exit();
            } else {
                echo "Error: " . $stmt->errorInfo()[2];
            }
        } else {
            echo "Error in preparing SQL statement: " . $pdo->errorInfo()[2];
        }
    } else {
        header('Location: http://localhost/Mini-PHP-Project/HTML/login.php?message=All fields are required&slide=register');
        exit();
    }
} else {
    echo "Invalid request";
    exit();
}
?>
