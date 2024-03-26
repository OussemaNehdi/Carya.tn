<?php

$first_name = $_POST['fname'];
$last_name = $_POST['lname'];
$email = $_POST['email'];
$password = $_POST['password'];

session_start();

$con = mysqli_connect('localhost', 'root', '', 'carrental');
if ($con->connect_error) {
    die ("Failed to connect : " . $con->connect_error);
} else {
    $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (? , ? , ? , ?)";
    $stmt = mysqli_prepare($con, $sql);
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $password);
    $stmt->execute();
    echo "Registration successful";
    $stmt->close();
    $con->close();
}

?>