<?php
    // Include file to check if the user is an admin
    
    // Include navbar
    include 'navbar.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Include CSS file -->
    <link rel="stylesheet" href="http://localhost/Mini-PHP-Project/CSS/style.css">
</head>
<body>
    <h1>Admin Dashboard</h1>

    <!-- Include user list -->
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
                // Include User class
                include '../src/Model/User.php';

                // Get all users
                $users = User::getAllUsers();

                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td>{$user['id']}</td>";
                    echo "<td>{$user['firstName']}</td>";
                    echo "<td>{$user['lastName']}</td>";
                    echo "<td>{$user['email']}</td>";
                    echo "<td>{$user['creation_date']}</td>";
                    echo "<td>{$user['role']}</td>";

                    // Display appropriate action based on user's role
                    echo "<td>";
                    if ($user['role'] == 'banned') {
                        echo "<a href=\"requests/unban_user.php?id={$user['id']}\">Unban</a>";
                    } else if ($user['role'] == 'admin') {
                        echo "Admin";
                    } else {
                        echo "<a href=\"requests/ban_user.php?id={$user['id']}\">Ban</a>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</section>


    <!-- Include car list -->
    <?php include 'car_list.php'; ?>

    <!-- Include command list -->
    <?php include 'command_list.php'; ?>

    <!-- User Info and Car Info Display -->
    <?php include 'info_popup.php'; ?>

    <!-- Add Car Button -->
    <button><a href="http://localhost/Mini-PHP-Project/PHP/add_car.php">Add Car</a></button>
    
    <!-- Include JavaScript file -->
    <script src="http://localhost/Mini-PHP-Project/JS/script.js"></script>
</body>
</html>
