<?php 
    $conn = mysqli_connect('localhost', 'root', '', 'carrental');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>
