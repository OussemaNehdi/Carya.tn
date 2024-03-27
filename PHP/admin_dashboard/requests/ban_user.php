<?php 
    // Bans a user
    include '../../connect.php';
    session_start();
    // Get user ID from GET parameter
    $user_id = $_GET['id'];

    // Initialize flag to track query execution status
    $success = true;

    // Delete user's commands
    $sql_delete_commands = "DELETE FROM command WHERE user_id=$user_id";
    if (!mysqli_query($conn, $sql_delete_commands)) {
        $success = false;
        echo "Error deleting commands: " . mysqli_error($conn) . "<br>";
    }

    // Update user's role to 'banned'
    $sql_update_user_role = "UPDATE users SET role='banned' WHERE id=$user_id";
    if (!mysqli_query($conn, $sql_update_user_role)) {
        $success = false;
        echo "Error updating user role: " . mysqli_error($conn) . "<br>";
    }

    // Delete user's cars

    // Get all car IDs from the owner ID
    $sql_select_car_ids = "SELECT id FROM cars WHERE owner_id=$user_id";
    $result = mysqli_query($conn, $sql_select_car_ids);

    // Initialize an array to store car IDs
    $car_ids = [];

    // Fetch car IDs from the result set
    while ($row = mysqli_fetch_assoc($result)) {
        $car_ids[] = $row['id'];
    }

    // Run the API for each car ID
    foreach ($car_ids as $car_id) {
        $api_url = "http://localhost/Mini-PHP-Project/PHP/delete_car.php?id=$car_id";
        
        // Initialize cURL session
        $curl = curl_init($api_url);
        
        // Set options for the cURL session
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return the response as a string instead of outputting it directly
        curl_setopt($curl, CURLOPT_FAILONERROR, true); // Fail on HTTP error codes (>= 400)
        
        // Execute the cURL request
        $response = curl_exec($curl);
        
        // Check for errors
        if ($response !== false) {
            echo "Car with ID $car_id deleted successfully!<br>";
        } else {
            $success = false;
            echo "Error deleting car with ID $car_id<br>";
        }
        
        // Close the cURL session
        curl_close($curl);
    }
    

    // Redirect with message if all queries executed successfully
    if ($success) {
        header('Location: http://localhost/Mini-PHP-Project/PHP/admin_dashboard/index.php?message=User banned successfully!');
    } else {
        echo "One or more errors occurred. User may not be banned completely.";
    }
?>
