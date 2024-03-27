<?php 
    include 'is_admin.php';
    include '../../connect.php'; // Include the file with database connection

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
        $sql_update_user_role = "UPDATE users SET role='banned' WHERE id=?";
        $stmt_update_user_role = $pdo->prepare($sql_update_user_role);
        $stmt_update_user_role->execute([$user_id]);

        // Delete user's cars
        $sql_select_car_ids = "SELECT id FROM cars WHERE owner_id=?";
        $stmt_select_car_ids = $pdo->prepare($sql_select_car_ids);
        $stmt_select_car_ids->execute([$user_id]);

        // Fetch car IDs from the result set
        $car_ids = $stmt_select_car_ids->fetchAll(PDO::FETCH_COLUMN);
        
        // Run the API for each car ID
foreach ($car_ids as $car_id) {
    // Set the URL for the DELETE request
$api_url = "http://localhost/Mini-PHP-Project/PHP/delete_car.php?id=$car_id";

// Initialize cURL session
$curl = curl_init($api_url);

// Set options for the cURL session
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return the response as a string instead of outputting it directly
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE"); // Set request method to DELETE

// Execute the cURL request
$response = curl_exec($curl);

// Check for errors
if ($response !== false) {
    // Check if the response indicates success
    echo "Car with ID $car_id deleted successfully!<br>";
} else {
    // Handle cURL errors
    $error = curl_error($curl);
    echo "Error deleting car with ID $car_id: $error<br>";
}

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
