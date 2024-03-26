<?php

session_start();

$con = mysqli_connect('localhost', 'root', '', 'carrental');
if ($con->connect_error) {
    die ("Failed to connect : " . $con->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset ($email) && isset ($password)) {

        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];


        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($con, $sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt_result = $stmt->get_result();

        if ($stmt_result->num_rows > 0) {
            $data = $stmt_result->fetch_assoc();
            if ($data['password'] === $password) {
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
    $stmt->close();
}
?>