<?php
// Include necessary files
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';

// The refferer is the page that redirected the user to this page
$refferer = isset($_POST['refferer']) ? parse_url($_POST['refferer'], PHP_URL_PATH) : (isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) : 'http://localhost/Mini-PHP-Project/carya.tn/index.php');

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); // Method Not Allowed
    exit("Method Not Allowed");
}

// Check if the 'id' parameter is set in the GET request
if (!isset($_GET['id'])) {
    header("Location: $refferer?message=Missing%20required%20parameters%20for%20marking%20car%20as%20available&type=error");
    exit();
}
    
// Get the user ID from GET parameter
$user_id = $_GET['id'];

try {
    // Attempt to unban the user by ID
    $user_to_unban = User::getUserById($user_id);
    // Check if the user exists
    if (!$user_to_unban) {
        header("Location: $refferer?message=User%20not%20found&type=error");
        exit();
    }
    
    $user_to_unban->unbanUserById();
    
    // Redirect with a success message
    header("Location:$refferer?message=User%20unbanned%20successfully.&type=success");
    exit(); // Ensure script execution stops after redirect
} catch (PDOException $e) {
    // Redirect with an error message if a PDO exception occurs
    header("$refferer?type=error&message=Error:%20" . urlencode($e->getMessage()));
    exit(); // Ensure script execution stops after redirect
} catch (Exception $ex) {
    // Redirect with an error message if any other exception occurs
    header("Location: $refferer?type=error&message=Error:%20" . urlencode($ex->getMessage()));
    exit(); // Ensure script execution stops after redirect
}
?>
