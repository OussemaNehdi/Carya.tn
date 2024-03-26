
<?php

session_start();

include_once ('connect.php');

$email = $_POST['email'];
$password = $_POST['password'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset ($email) && isset ($password)) {

        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];


        $sql = "SELECT * FROM users WHERE email = '$email'";
        $users = mysqli_query($conn, $sql);

        if (mysqli_num_rows($users) > 0) {
            if (password_verify($password, $user['password'])) {
                header('Location: home.php');
                exit();
            } else {
                echo "Incorrect password";
            }
        } else {
            echo "User not found";
        }
    } else {
        echo "Email or password not provided";
    }
}
?>