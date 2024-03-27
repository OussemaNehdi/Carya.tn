<section>
    <h2>List of Car Commands</h2>
    <table>
        <thead>
            <tr>
                <th>Command ID</th>
                <th>Car ID</th>
                <th>User ID</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Price Paid</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch car commands from the database
            $sql = "SELECT * FROM command";
            $car_commands = mysqli_query($conn, $sql);
            foreach ($car_commands as $command) {
                // Calculate end date based on start date and duration
                $start_date = $command['start_date'];
                $duration = $command['rental_period']; // Duration in days
                $end_date = date('Y-m-d', strtotime($start_date . ' + ' . $duration . ' days'));
                // Fetch car information for the command
                $sql_car = "SELECT * FROM cars WHERE id={$command['car_id']}";
                $car = mysqli_query($conn, $sql_car);
                $car = mysqli_fetch_assoc($car);
                $price = $car['price'];
                // Display car command information
                echo "<tr>";
                echo "<td>{$command['command_id']}</td>";
                echo "<td class='car-info' data-id='{$command['car_id']}'>{$command['car_id']}</td>";
                echo "<td class='user-info' data-id='{$command['user_id']}'>{$command['user_id']}</td>";
                echo "<td>{$start_date}</td>";
                echo "<td>{$end_date}</td>";
                // Calculate price paid based on price per day and duration
                $price_paid = $price * $duration;
                echo "<td>{$price_paid}</td>";
                echo "<td><a href=\"http://localhost/Mini-PHP-Project/PHP/admin_dashboard/requests/cancel_command.php?id={$command['command_id']}\">Cancel Command</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</section>
