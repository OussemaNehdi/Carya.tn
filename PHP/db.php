<?php 
    $conn = mysqli_connect('localhost', 'root', '', 'brodb');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>