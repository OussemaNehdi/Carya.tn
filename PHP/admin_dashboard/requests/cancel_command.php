<?php 
    include 'is_admin.php';

    if (isset($_GET['id'])) {
        include '../../connect.php';
        
        // Get the command ID from the GET parameter
        $id = $_GET['id'];
        
        try {
            // Prepare the SQL statement to delete the command
            $sql = "DELETE FROM command WHERE command_id=?";
            $stmt = $pdo->prepare($sql);
            
            // Bind the command ID parameter and execute the statement
            $stmt->execute([$id]);
            
            // Redirect with a success message
            header('Location: http://localhost/Mini-PHP-Project/PHP/admin_dashboard/index.php?message=Command canceled successfully!');
            exit(); // Ensure script execution stops after redirect
        } catch (PDOException $e) {
            // Redirect with an error message if an exception occurs
            header('Location: http://localhost/Mini-PHP-Project/PHP/admin_dashboard/index.php?message=Error canceling command!');
            exit(); // Ensure script execution stops after redirect
        }
    } else {
        // Redirect with an error message if the command ID is not set
        header('Location: http://localhost/Mini-PHP-Project/PHP/admin_dashboard/index.php?message=Error canceling command!');
        exit(); // Ensure script execution stops after redirect
    }
?>
