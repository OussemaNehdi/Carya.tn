<?php


// Check if the session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php';
// Include the User model
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Get the form data, sanitize the email
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        // Get the user from the database
        $user = User::getUserByEmail($email);
        
        // If the user exists
        if ($user) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            // Check if the password is correct
            if ($user->password === $password) {
                // Check if the user is banned
                if ($user->role === 'banned') {
                    header('Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/login.php?message=You_are_banned&slide=login');
                    exit();
                }
                // Set the session variables
                $_SESSION['user'] = $user->firstName;
                $_SESSION['user_id'] = $user->id;
                $_SESSION['role'] = $user->role;

                header('Location: http://localhost/Mini-PHP-Project/carya.tn/index.php');
                exit();
            } else {
                header('Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/login.php?message=Incorrect_password&slide=login');
                exit();
            }
        } else {
            echo "User not found";
            header('Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/login.php?message=User_not_found&slide=login');
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