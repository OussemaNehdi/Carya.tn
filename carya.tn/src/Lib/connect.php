<?php
try {
    // Establish a connection to the database using PDO
    $dsn = "mysql:host=localhost;dbname=carrental;charset=utf8mb4";
    $username = "root";
    $password = "";

    $pdo = new PDO($dsn, $username, $password);

    // Set PDO to throw exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Your remaining code using PDO goes here...
} catch (PDOException $e) {
    // Handle connection errors
    die("Connection failed: " . $e->getMessage());
}
?>
