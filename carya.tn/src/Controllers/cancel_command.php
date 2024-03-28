<?php 
    include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/controllers/is_admin.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Command.php';

    if (isset($_GET['id'])) {
        
        // Get the command ID from the GET parameter
        $id = $_GET['id'];
        
        try {
            Command::deleteRentalCommandById($id);          
            
            // Redirect with a success message
            header('Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/admin_dashboard.php?message=Command canceled successfully!');
            exit(); // Ensure script execution stops after redirect
        } catch (PDOException $e) {
            // Redirect with an error message if an exception occurs
            header('Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/admin_dashboard.php?message=Error canceling command!');
            exit(); // Ensure script execution stops after redirect
        }
    } else {
        // Redirect with an error message if the command ID is not set
        header('Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/admin_dashboard.php?message=Error canceling command!');
        exit(); // Ensure script execution stops after redirect
    }
?>
