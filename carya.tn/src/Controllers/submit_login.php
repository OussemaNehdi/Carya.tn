<?php
// Check if the session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Get the form data, sanitize the email
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        // Prepare and execute the query
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $data = $stmt->fetch();

        // If the user exists
        if ($data) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            // Check if the password is correct
            if ($data['password'] === $hashed_password) {
                // Check if the user is banned
                if ($data['role'] === 'banned') {
                    header('Location: http://localhost/Mini-PHP-Project/HTML/login.php?message=You are banned&slide=login');
                    exit();
                }
                // Set the session variables
                $_SESSION['user'] = $data['firstName'];
                $_SESSION['user_id'] = $data['id'];
                $_SESSION['role'] = $data['role'];

                header('Location: http://localhost/Mini-PHP-Project/');
                exit();
            } else {
                header('Location: http://localhost/Mini-PHP-Project/HTML/login.php?message=Incorrect_password&slide=login');
                exit();
            }
        } else {
            echo "User not found";
            header('Location: http://localhost/Mini-PHP-Project/HTML/login.php?message=User_not_found&slide=login');
            exit();
        }
    } else {
        echo "Email or password not provided";
    }
} else {
    echo "Invalid request";
}

// Close the database connection
$pdo = null;
?>