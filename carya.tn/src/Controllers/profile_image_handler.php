<?php 
include_once 'image_upload_handler.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';

// This code handels the image upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required parameters are set
    if (!isset($_FILES['profile_image'])) {
        // Redirect with an error message if any required parameter is missing
        header("Location: $refferer?message=Missing%20required%20parameters%20for%20adding%20car.");
        exit();
    }

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    $refferer = isset($_POST['refferer']) ? parse_url($_POST['refferer'], PHP_URL_PATH) : (isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) : 'http://localhost/Mini-PHP-Project/carya.tn/index.php');
    $file_name = handleImageUpload($_FILES['profile_image'], '/Mini-PHP-Project/carya.tn/Resources/profile_images/');

    if (strpos($file_name, "Error") !== false) {
        $refferer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
        header("Location: $refferer?message=$file_name");
        exit();
    } else {
        try {
            // Update user's profile image in the database
            $user = User::getUserById($_SESSION['user_id']);
            if ($user->profile_image) {
                unlink($_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/Resources/profile_images/' . $user->profile_image);
            }
            $user->updateProfileImageById($file_name);
            header("Location: $refferer?message=Profile%20image%20updated%20successfully.");
        } catch (Exception $e) {
            header("Location: $refferer?error=Error:%20" . urlencode($e->getMessage()));
            exit();
        }
    }
}
?>