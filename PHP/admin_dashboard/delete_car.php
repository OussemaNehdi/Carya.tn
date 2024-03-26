<?php 
    include '../connect.php';
    $car_id = $_GET['id'];
    $sql = "DELETE FROM cars WHERE id=$car_id";
    if (mysqli_query($conn, $sql)) {
        header('Location: index.php');
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
?>