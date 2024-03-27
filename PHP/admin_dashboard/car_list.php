<?php
    include '../connect.php';
    // Fetch cars from the database
    $sql = "SELECT * FROM cars";
    $stmt = $pdo->query($sql);
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<style>
    .car-image {
        cursor: pointer;
        width: 100px;
    }
</style>

<section>
    <h2>List of Cars</h2>
    <table>
        <thead>
            <tr>
                <th>Car ID</th>
                <th>Car Brand</th>
                <th>Car Model</th>
                <th>Color</th>
                <th>Kilometers</th>
                <th>Owner</th>
                <th>Price</th>
                <th>Available</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($cars as $car) {
                // Display car information and actions
                echo "<tr>";
                echo "<td class='car-image' data-id='{$car['id']}'>{$car['id']}</td>";
                echo "<td class='car-image' data-id='{$car['id']}'>{$car['brand']}</td>";
                echo "<td class='car-image' data-id='{$car['id']}'>{$car['model']}</td>";
                echo "<td class='car-image' data-id='{$car['id']}'>{$car['color']}</td>";
                echo "<td>{$car['km']}</td>";
                echo "<td class='user-info' data-id='{$car['owner_id']}'>{$car['owner_id']}</td>";
                echo "<td>{$car['price']}</td>";

                // Check if the car is available
                $current_date = date('Y-m-d');
                $car_commanded_sql = "SELECT * FROM command WHERE car_id=? AND start_date <= ? AND end_date >= ?";
                $car_commanded_stmt = $pdo->prepare($car_commanded_sql);
                $car_commanded_stmt->execute([$car['id'], $current_date, $current_date]);
                $car_commanded = $car_commanded_stmt->fetchAll(PDO::FETCH_ASSOC);
                $available = count($car_commanded) == 0;

                if (!$available) {
                    echo "<td>Not Available</td>";
                } else {
                    echo "<td>Available</td>";
                }

                // Display actions based on availability
                echo "<td>";
                if ($available) {
                    echo "<a href='http://localhost/Mini-PHP-Project/PHP/delete_car.php?id={$car['id']}'>Delete</a>";
                    // Add update option if the user is the owner of the car
                    if ($car['owner_id'] == $_SESSION['user_id']) {
                        echo " | <a href='../update_car.php?id={$car['id']}'>Update</a>";
                    }
                } else {
                    echo "Car is in use";
                }
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</section>