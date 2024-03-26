

<?php 
    include '../../HTML/navbar.php';
?>

<?php 
    include('../connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="http://localhost/Mini-PHP-Project/CSS/style.css">
    <script src="http://localhost/Mini-PHP-Project/JS/script.js" defer></script>
    <style>
        .car-image {
            display: none;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard - Car Rental</h1>

    <!-- List of Users -->
    <section>
        <h2>List of Users</h2>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Created</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM users";
                $users = mysqli_query($conn, $sql);
                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td>{$user['id']}</td>";
                    echo "<td>{$user['firstName']}</td>";
                    echo "<td>{$user['lastName']}</td>";
                    echo "<td>{$user['email']}</td>";
                    echo "<td>{$user['creation_date']}</td>";
                    echo "<td>{$user['role']}</td>";
                    if ($user['role'] == 'banned') {
                        echo "<td><a href=\"unban_user.php?id={$user['id']}\">Unban</a></td>";
                    }
                    else {
                        echo "<td><a href=\"ban_user.php?id={$user['id']}\">Ban</a></td>";
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <!-- List of Cars -->
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
                $sql = "SELECT * FROM cars";
                $cars = mysqli_query($conn, $sql);
                foreach ($cars as $car) {
                    echo "<tr onclick=\"toggleCarImage({$car['id']})\">"; // Call JavaScript function when clicking on a row
                    echo "<td>{$car['id']}</td>";
                    echo "<td>{$car['brand']}</td>";
                    echo "<td>{$car['model']}</td>";
                    echo "<td>{$car['color']}</td>";
                    echo "<td>{$car['km']}</td>";
                    echo "<td>{$car['owner_id']}</td>";
                    echo "<td>{$car['price']}</td>";
                    echo "<td><a href=\"delete_car.php?id={$car['id']}\">Delete</a> | <a href=\"update_car.php?id={$car['id']}\">Update</a></td>";
                    echo "</tr>";
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
         
    <button><a href="http://localhost/Mini-PHP-Project/PHP/add_car.php">Add Car</a></button>
</body>
</html>

