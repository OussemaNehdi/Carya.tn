<?php 
    if(isset($_GET['id'])) {
        include '../../connect.php';
        $id = $_GET['id'];
        
        $sql = "DELETE FROM command WHERE command_id=$id";
        $result = mysqli_query($conn, $sql);
        
        header('Location: http://localhost/Mini-PHP-Project/PHP/admin_dashboard/index.php?message=Command canceled successfully!');
    } else {
        header('Location: http://localhost/Mini-PHP-Project/PHP/admin_dashboard/index.php?message=Error canceling command!');
    }
?>