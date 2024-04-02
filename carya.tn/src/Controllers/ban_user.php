<?php 
// Admin path guard
include 'is_admin.php';
?>

<?php
// Include necessary files
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Command.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php';

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    exit("Method Not Allowed");
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// The reffer will be the page that the user will be sent to once the code is executed
$refferer = isset($_POST['refferer']) ? parse_url($_POST['refferer'], PHP_URL_PATH) : (isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) : 'http://localhost/Mini-PHP-Project/carya.tn/index.php');

// Check if user ID is set in the GET parameters
if (!isset($_GET['id'])) {
    header("Location: $refferer?message=Error:%20User%20ID%20not%20set.&type=error");
    exit();
}

// Get user ID from GET parameter
$user_id = $_GET['id'];

try {
    // Begin a transaction
    $pdo->beginTransaction();

    // Delete rental commands associated with the user
    Command::deleteRentalCommandByUserId($user_id);

    // Update user's role to 'banned'
    $user_to_ban = User::getUserById($user_id);
    $user_to_ban->banUserById();

    // Delete user's cars
    $cars_to_delete = $user_to_ban->getCarsByOwnerId();
    foreach ($cars_to_delete as $car) {
        // Set the URL for the DELETE request
        $api_url = "http://localhost/Mini-PHP-Project/carya.tn/src/controllers/delete_car.php?id=$car->id";

        // Initialize cURL session
        $curl = curl_init($api_url);
        // Set cURL options
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // Execute the cURL request
        $response = curl_exec($curl);

        // Check for errors
        if ($response === false) {
            throw new Exception('Curl error: ' . curl_error($curl));
        }

        // Close the cURL session
        curl_close($curl);
    }

    // Commit the transaction
    $pdo->commit();

    // Redirect to admin dashboard with success message
    header("Location: $refferer?message=User%20has%20been%20successfully%20banned.&type=success");
    exit();
} catch (PDOException $e) {
    // Rollback the transaction and handle PDO exceptions
    $pdo->rollBack();
    header("Location: $refferer?type=error&message=PDO%20Error:%20" . urlencode($e->getMessage()));
    exit();
} catch (Exception $ex) {
    // Rollback the transaction and handle other exceptions
    $pdo->rollBack();
    header("Location: $refferer?type=error&message=" . urlencode($ex->getMessage()));
    exit();
}
?>
