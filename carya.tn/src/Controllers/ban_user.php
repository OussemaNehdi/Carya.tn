<?php 
    include 'is_admin.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Command.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';

    // Bans a user
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Get user ID from GET parameter
    $user_id = $_GET['id'];

    try {
        // Initialize flag to track query execution status
        $success = true;

        // Begin a PDO transaction
        $pdo->beginTransaction();

        // Delete user's commands
        $sql_delete_commands = "DELETE FROM command WHERE user_id=?";
        $stmt_delete_commands = $pdo->prepare($sql_delete_commands);
        $stmt_delete_commands->execute([$user_id]);

        // Update user's role to 'banned'
        User::banUserById($user_id);

        // Delete user's cars
        $cars_to_delete = Car::getCarsByOwnerId($user_id);

        
        
        // Run the API for each car ID
foreach ($cars_to_delete as $car) {
    // Set the URL for the DELETE request
$api_url = "http://localhost/Mini-PHP-Project/carya.tn/src/controllers/delete_car.php?id=$car->id";

// Initialize cURL session
$curl = curl_init($api_url);
// Execute the cURL request
$response = curl_exec($curl);

// Close the cURL session
curl_close($curl);

}

        // Commit the transaction if all queries executed successfully
        if ($success) {
            $pdo->commit();
        } else {
            echo "One or more errors occurred. User may not be banned completely.";
        }
    } catch (PDOException $e) {
        // Rollback the transaction and handle any exceptions
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
?>
