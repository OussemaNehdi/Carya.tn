<?php 
    include '../connect.php';
    $user_id = $_GET['id'];
    $sql = "UPDATE users SET role='banned' WHERE id=$user_id";
    if (mysqli_query($conn, $sql)) {
        header('Location: index.php');
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
?>