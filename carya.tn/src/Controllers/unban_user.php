<?php
    include 'is_admin.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
        
        $user_id = $_GET['id'];
        
        try {
            User::unbanUserById($user_id);
            
            header('Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/admin_dashboard.php?message=User unbanned successfully');
            exit(); // Ensure script execution stops after redirect
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid request";
    }
?>
