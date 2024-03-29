<?php
    // Include necessary files
    include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';

    // Set title and class
    $title = "Admin Dashboard";
    $class = "";

    // Start output buffering
    ob_start();

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Fetch the user's owned cars
    if (!isset($_SESSION['user_id'])) {
        header("Location: http://localhost/Mini-PHP-Project/carya.tn/templates/login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $user = User::getUserById($user_id);
    $owned_cars = $user->getCarsByOwnerId($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Car Listings</title>
    <style><!-- TODO : put this style in style.css instead -->
        /* Style the car listing container */
        .car-listing {
            display: flex;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
        }

        /* Style the car image */
        .car-image {
            flex: 0 0 auto;
            margin-right: 20px;
        }

        .car-image img {
            max-width: 150px;
            max-height: 100px;
        }

        /* Style the car details */
        .car-details {
            flex: 1 1 auto;
        }

        /* Style the buttons */
        .action-buttons button {
            margin-right: 10px;
        }

        /* Popup styling */
        .popup {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 9999;
            padding-top: 100px;
        }

        .popup-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            text-align: center;
        }

        /* Close button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>My Car Listings</h1>

    <?php foreach ($owned_cars as $car): ?>
    <div class="car-listing">
        <div class="car-image">
            <img src="/Mini-PHP-Project/carya.tn/Resources/car_images/<?php echo $car->image; ?>" alt="Car Image">
        </div>
        <div class="car-details">
            <h2><?php echo $car->brand . ' ' . $car->model; ?></h2>
            <p><?php echo $car->model; ?></p>
            <p>Color: <?php echo $car->color; ?></p>
            <p>Price: <?php echo $car->price; ?></p>
            <p>Kilometers: <?php echo $car->km; ?></p>
            <!-- Add other attributes here -->
            <?php
            if ($car->isCarInUse()) {
                echo "<p>This car is in use</p>";
            } else {
                echo '<div class="action-buttons">';
                echo "<a href='http://localhost/Mini-PHP-Project/carya.tn/src/controllers/delete_car.php?id={$car->id}'><button>Delete Listing</button></a>";
                if ($car->isCarMarkedUnavailable()) {
                    echo "<a href='http://localhost/Mini-PHP-Project/carya.tn/src/controllers/mark_car_available.php?id={$car->id}'><button>Mark Available</button></a>";
                } else {
                    echo "<a href='http://localhost/Mini-PHP-Project/carya.tn/src/controllers/mark_car_unavailable.php?id={$car->id}'><button>Mark Unavailable</button></a>";
                }
                // Button to trigger popup
                echo "<button onclick=\"document.getElementById('popup{$car->id}').style.display='block'\">Update Listing</button>";
                echo '</div>';
            } 
            ?>
        </div>
    </div>

    <!-- Popup -->
    <div id="popup<?php echo $car->id ?>" class="popup">
        <div class="popup-content">
            <span class="close" onclick="document.getElementById('popup<?php echo $car->id ?>').style.display='none'">&times;</span>
            <h2>Update Car Listing</h2>
            <form action="http://localhost/Mini-PHP-Project/carya.tn/src/controllers/update_car.php" method="POST" enctype="multipart/form-data">
                <label for="brand">Car Brand:</label><br>
                <input type="text" id="brand" name="brand" value="<?php echo $car->brand; ?>"><br>
                <label for="model">Car Model:</label><br>
                <input type="text" id="model" name="model" value="<?php echo $car->model; ?>"><br>
                <label for="color">Car Color:</label><br>
                <input type="text" id="color" name="color" value="<?php echo $car->color; ?>"><br>
                <label for="price">Car Price:</label><br>
                <input type="text" id="price" name="price" value="<?php echo $car->price; ?>"><br>
                <label for="km">Car Kilometers:</label><br>
                <input type="text" id="km" name="km" value="<?php echo $car->km; ?>"><br>
                <label for="image">Upload New Car Image:</label><br>
                <input type="file" id="image" name="image"><br>
                <input type="hidden" id="car_id" name="car_id" value="<?php echo $car->id; ?>">
                <input type="submit" value="Update Car">
            </form>
        </div>
    </div>
    <?php endforeach; ?>
</body>
</html>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>