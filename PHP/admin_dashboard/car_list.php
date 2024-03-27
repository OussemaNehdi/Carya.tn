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
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch cars from the database
            $sql = "SELECT * FROM cars";
            $cars = mysqli_query($conn, $sql);
            foreach ($cars as $car) {
                // Display car information and actions
                echo "<tr onclick=\"toggleCarImage({$car['id']})\">"; // Call JavaScript function when clicking on a row
                echo "<td>{$car['id']}</td>";
                echo "<td>{$car['brand']}</td>";
                echo "<td>{$car['model']}</td>";
                echo "<td>{$car['color']}</td>";
                echo "<td>{$car['km']}</td>";
                echo "<td>{$car['owner_id']}</td>";
                echo "<td>{$car['price']}</td>";
                echo "<td><a href=\"http://localhost/Mini-PHP-Project/PHP/delete_car.php?id={$car['id']}\">Delete</a>";
                // Add update option if the user is the owner of the car
                if ($car['owner_id'] == $_SESSION['user_id']) {
                    echo " | <a href=\"../update_car.php?id={$car['id']}\">Update</a>";
                }
                echo "</td>";
                echo "</tr>";
                // Display car image row
                echo "<tr class=\"car-image-row\">";
                echo "<td colspan=\"8\">";
                echo "<img id=\"car-image-{$car['id']}\" class=\"car-image\" src=\"http://localhost/Mini-PHP-Project/Resources/Images/car_images/{$car['image']}\" alt=\"Car Image\">"; // Image element with unique ID
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</section>
