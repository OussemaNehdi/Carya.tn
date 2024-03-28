<?php
// Admin path guard
include 'is_admin.php';
?>

<?php
// Include necessary files
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Command.php';

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); // Method Not Allowed
    exit("Method Not Allowed");
}

// Check if the 'id' parameter is set in the GET request
if (!isset($_GET['id'])) {
    // Redirect with an error message if the command ID is not set
    header('Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/admin_dashboard.php?error=Error:%20Command%20ID%20not%20set.');
    exit(); // Ensure script execution stops after redirect
}

// Get the command ID from the GET parameter
$id = $_GET['id'];

try {
    // Attempt to delete the rental command by ID
    $command = Command::getRentalCommandById($id);
    $command->deleteRentalCommandById();

    // Redirect with a success message
    header('Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/admin_dashboard.php?message=Command%20canceled%20successfully!');
    exit(); // Ensure script execution stops after redirect
} catch (PDOException $e) {
    // Redirect with an error message if a PDO exception occurs
    header('Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/admin_dashboard.php?error=Error:%20Canceling%20command:%20PDO%20Error');
    exit(); // Ensure script execution stops after redirect
} catch (Exception $ex) {
    // Redirect with an error message if any other exception occurs
    header('Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/admin_dashboard.php?error=Error:%20Canceling%20command:%20' . urlencode($ex->getMessage()));
    exit(); // Ensure script execution stops after redirect
}
?>
