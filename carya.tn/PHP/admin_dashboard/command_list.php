<?php
require_once('../connect.php'); // Include your database connection file
require_once('../../classes/User.php');
require_once('../../classes/Car.php');
require_once('../../classes/RentalCommand.php');

try {
    // Prepare and execute SQL query to fetch car commands
    $sql = "SELECT * FROM command";
    $stmt = $pdo->query($sql);
    $car_commands_result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display car commands
    echo "<section>";
    echo "<h2>List of Car Commands</h2>";
    echo "<table>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Command ID</th>";
    echo "<th>Car ID</th>";
    echo "<th>User ID</th>";
    echo "<th>Start Date</th>";
    echo "<th>End Date</th>";
    echo "<th>Price Paid</th>";
    echo "<th>Actions</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($car_commands_result as $command_row) {
        // Fetch car information for the command
        $car_sql = "SELECT * FROM cars WHERE id=:car_id";
        $car_stmt = $pdo->prepare($car_sql);
        $car_stmt->bindParam(':car_id', $command_row['car_id']);
        $car_stmt->execute();
        $car_data = $car_stmt->fetch(PDO::FETCH_ASSOC);
        $car = new Car($car_data['id'], $car_data['brand'], $car_data['model'], $car_data['color'], $car_data['image'], $car_data['km'], $car_data['price'], $car_data['owner_id']);

        // Fetch user information for the command
        $user_sql = "SELECT * FROM users WHERE id=:user_id";
        $user_stmt = $pdo->prepare($user_sql);
        $user_stmt->bindParam(':user_id', $command_row['user_id']);
        $user_stmt->execute();
        $user_data = $user_stmt->fetch(PDO::FETCH_ASSOC);
        $user = new User($user_data['id'], $user_data['firstName'], $user_data['lastName'], $user_data['password'], $user_data['email'], $user_data['creation_date'], $user_data['role']);

        // Create object of RentalCommand class
        $car_command = new Command($command_row['command_id'], $car, $user, $command_row['rental_date'], $command_row['start_date'], $command_row['end_date'], $command_row['rental_period']);

        // Calculate end date based on start date and duration
        $end_date = date('Y-m-d', strtotime($car_command->start_date . ' + ' . $car_command->rental_period . ' days'));
        // Calculate price paid based on price per day and duration
        $price_paid = $car->price * $car_command->rental_period;

        // Display car command information
        echo "<tr>";
        echo "<td>{$car_command->command_id}</td>";
        echo "<td class='car-info' data-id='{$car->id}'>{$car->id}</td>";
        echo "<td class='user-info' data-id='{$user->id}'>{$user->id}</td>";
        echo "<td>{$car_command->start_date}</td>";
        echo "<td>{$end_date}</td>";
        echo "<td>{$price_paid}</td>";
        echo "<td><a href=\"http://localhost/Mini-PHP-Project/PHP/admin_dashboard/requests/cancel_command.php?id={$car_command->command_id}\">Cancel Command</a></td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</section>";
} catch (PDOException $e) {
    // Handle database errors
    echo "Error: " . $e->getMessage();
}
?>
