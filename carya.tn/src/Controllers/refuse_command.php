<?php
// Include the Command model
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Command.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); // Method Not Allowed
    exit("Method Not Allowed");
}

// Check if all required parameters are set
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// The refferer is the page that redirected the user to this page
$refferer = isset($_POST['refferer']) ? parse_url($_POST['refferer'], PHP_URL_PATH) : (isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) : 'http://localhost/Mini-PHP-Project/carya.tn/index.php');

// Get the command id from the POST request
$command_id = $_POST['command_id'];

try {
    // Refuse the command
    Command::RefuseCommand($command_id);
    header("Location: $refferer?message=Command%20Refused%20.&type=success");
} catch (Exception $e) {
    header("Location: $refferer?type=error&message=Error:%20" . urlencode($e->getMessage()));
    exit();

}
?>