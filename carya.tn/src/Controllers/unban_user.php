<?php
    // Include necessary files
    include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';
    
    // Check if the request method is GET and 'id' parameter is set
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
        
        // Get the user ID from GET parameter
        $user_id = $_GET['id'];
        
        try {
            // Attempt to unban the user by ID
            $user_to_unban = User::getUserById($user_id);
            $user_to_unban->unbanUserById();
            
            // Redirect with a success message
            header('Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/admin_dashboard.php?message=User%20unbanned%20successfully.');
            exit(); // Ensure script execution stops after redirect
        } catch (PDOException $e) {
            // Redirect with an error message if a PDO exception occurs
            header('Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/admin_dashboard.php?error=Error:%20' . urlencode($e->getMessage()));
            exit(); // Ensure script execution stops after redirect
        } catch (Exception $ex) {
            // Redirect with an error message if any other exception occurs
            header('Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/admin_dashboard.php?error=Error:%20' . urlencode($ex->getMessage()));
            exit(); // Ensure script execution stops after redirect
        }
    } else {
        // Redirect with an error message if the request is invalid
        header('Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/admin_dashboard.php?error=Invalid%20request.');
        exit(); // Ensure script execution stops after redirect
    }
?>
