<?php 
// Includes the necessary files
include_once 'image_upload_handler.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';

// This code handels the image upload
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); // Method Not Allowed
    exit("Method Not Allowed");
}

// Check if all required parameters are set
if (!isset($_FILES['profile_image'])) {
    // Redirect with an error message if any required parameter is missing
    header("Location: $refferer?message=Missing%20required%20parameters%20for%20adding%20car.&type=error");
    exit();
}

// Start the session if it is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// The refferer is the page that redirected the user to this page
$refferer = isset($_POST['refferer']) ? parse_url($_POST['refferer'], PHP_URL_PATH) : (isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) : 'http://localhost/Mini-PHP-Project/carya.tn/index.php');

// Handle the image upload
$file_name = handleImageUpload($_FILES['profile_image'], '/Mini-PHP-Project/carya.tn/Resources/profile_images/');

// Check if the file name contains the word "Error"
if (strpos($file_name, "Error") !== false) {
    $refferer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
    header("Location: $refferer?type=error&message=$file_name");
    exit();
} else {
    try {
        // Update user's profile image in the database
        $user = User::getUserById($_SESSION['user_id']);

        // Check if the user exists
        if (!$user) {
            header("Location: $refferer?type=error&message=User%20not%20found.");
            exit();
        }

        // Delete the old profile image if it exists
        if ($user->profile_image) {
            unlink($_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/Resources/profile_images/' . $user->profile_image);
        }

        // Update the user's profile image
        $user->updateProfileImageById($file_name);
        header("Location: $refferer?message=Profile%20image%20updated%20successfully.&type=success");
    } catch (Exception $e) {
        header("Location: $refferer?type=error&message=Error:%20" . urlencode($e->getMessage()));
        exit();
    }
}
?>