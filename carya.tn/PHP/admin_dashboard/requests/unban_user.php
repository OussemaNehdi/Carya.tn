<?php
    include 'is_admin.php';

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
        include '../../connect.php';
        
        $user_id = $_GET['id'];
        
        try {
            $sql = "UPDATE users SET role='customer' WHERE id=:id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();
            
            header('Location: http://localhost/Mini-PHP-Project/PHP/admin_dashboard/');
            exit(); // Ensure script execution stops after redirect
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid request";
    }
?>
