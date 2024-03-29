<?php
// Include necessary files
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';

// Set title and class
$title = "List your cars";
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
$owned_cars = $user->getCarsByOwnerId();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="http://localhost/Mini-PHP-Project/carya.tn/script.js"></script>
    <title>My Car Listings</title>
    <style>
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

        
        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;

            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>
<body>
    <h1>My Car Listings</h1>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Add event listener to each "Update Listing" button
            <?php foreach ($owned_cars as $car): ?>
            document.getElementById("UpdateCarBtn<?php echo $car->id ?>").addEventListener("click", function() {
                // Show the corresponding popup and overlay
                document.getElementById("popup<?php echo $car->id ?>").style.display = "block";
                document.getElementById("overlay").style.display = "block";
            });
            <?php endforeach; ?>

            // Close all popups and overlay when clicking outside the popups
            document.getElementById("overlay").addEventListener("click", function() {
                // Hide all popups and overlay
                <?php foreach ($owned_cars as $car): ?>
                document.getElementById("popup<?php echo $car->id ?>").style.display = "none";
                <?php endforeach; ?>
                document.getElementById("overlay").style.display = "none";
            });
        });
    </script>

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
            <?php if ($car->isCarInUse()): ?>
                <p>This car is in use</p>
            <?php else: ?>
                <div class="action-buttons">
                    <a href='http://localhost/Mini-PHP-Project/carya.tn/src/controllers/delete_car.php?id=<?php echo $car->id; ?>'><button>Delete Listing</button></a>
                    <?php if ($car->isCarMarkedUnavailable()): ?>
                        <a href='http://localhost/Mini-PHP-Project/carya.tn/src/controllers/mark_car_available.php?id=<?php echo $car->id; ?>'><button>Mark Available</button></a>
                    <?php else: ?>
                        <a href='http://localhost/Mini-PHP-Project/carya.tn/src/controllers/mark_car_unavailable.php?id=<?php echo $car->id; ?>'><button>Mark Unavailable</button></a>
                    <?php endif; ?>
                    <!-- Button to trigger popup -->
                    <button id='UpdateCarBtn<?php echo $car->id; ?>'>Update Listing</button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Popup -->
    <div id="popup<?php echo $car->id ?>" class="popup">
        <div class="popup-content">

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

<button id="addCarBtn">Add Car</button>

<!-- Popup content -->
<div class="popup" id="addCarPopup">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/templates/add_car_form.php'; ?>
</div>

<!-- Overlay to cover the background -->
<div class="overlay" id="overlay"></div>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>
