<?php
    include 'is_admin.php';
?>

<?php 
    // unbans a banned user
    include '../../connect.php';
    $user_id = $_GET['id'];
    $sql = "UPDATE users SET role='customer' WHERE id=$user_id";
    if (mysqli_query($conn, $sql)) {
        header('Location: http://localhost/Mini-PHP-Project/PHP/admin_dashboard/');
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
?>