<?php
// Include necessary files
// Last commit by AgressivePug to add the commands mangment functionnaility
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Command.php';
// Set title and class
$title = "My Cars";
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
if (isset($_GET) && !empty($_GET)) {
    $filters = Car::constructFilterQuery($_GET);
    $cars = $user->getCarsByOwnerId($filters);
} else {
    $cars = $user->getCarsByOwnerId();
}
//AgressivePug : fetching commands


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cars</title>
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

        .container {
            display: flex;
        }
    </style>
</head>
<body>
    <h1>My Car Listings</h1>

    <script>// Changed by AgressivePug
    
    function displayFileNameUpdate(input, id) {
            
            var fileName = input.files[0].name;
            var fileNameElement = document.getElementById('update-name' + id);
            if (fileName.length > 20) {
                fileName = fileName.substring(0, 20) + "..."; // Truncate if over 20 characters
            }
            fileNameElement.textContent = fileName;
        }
        document.addEventListener("DOMContentLoaded", function() {
    <?php foreach ($cars as $car): ?>
        // Add event listener for "Update Listing" button
        document.getElementById("UpdateCarBtn<?php echo $car->id ?>").addEventListener("click", function() {
            document.getElementById("popup<?php echo $car->id ?>").style.display = "block";
            document.getElementById("overlay").style.display = "block";
        });

        // Add event listener for "Confirm Commands" button
        document.getElementById("ConfirmCommandsBtn<?php echo $car->id ?>").addEventListener("click", function() {
            document.getElementById("commandsPopup<?php echo $car->id ?>").style.display = "block";
            document.getElementById("overlay").style.display = "block";
        });

    <?php endforeach; ?>

    // Add event listener to close popups and overlay when clicking outside popups
    document.getElementById("overlay").addEventListener("click", function() {
        <?php foreach ($cars as $car): ?>
            document.getElementById("popup<?php echo $car->id ?>").style.display = "none";
            document.getElementById("commandsPopup<?php echo $car->id ?>").style.display = "none";
        <?php endforeach; ?>
        document.getElementById("addCarPopup").style.display = "none";
        document.getElementById("overlay").style.display = "none";
    });
    document.getElementById("addCarBtn").addEventListener("click", function() {
        document.getElementById("addCarPopup").style.display = "block";
        document.getElementById("overlay").style.display = "block";
    });
});
    </script>
    <button id="addCarBtn">Add Car</button>

    <div class="container">
        <div class="filter-menu">
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/Templates/filter_menu.php'; ?>
        </div>
        <div>
            <?php foreach ($cars as $car): ?>
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
                        
                            <div class="action-buttons">
                                <a href='http://localhost/Mini-PHP-Project/carya.tn/src/controllers/delete_car.php?id=<?php echo $car->id; ?>'><button>Delete Listing</button></a>
                                <?php if ($car->isCarMarkedUnavailable()): ?>
                                    <a href='http://localhost/Mini-PHP-Project/carya.tn/src/controllers/mark_car_available.php?id=<?php echo $car->id; ?>'><button>Mark Available</button></a>
                                <?php else: ?>
                                    <a href='http://localhost/Mini-PHP-Project/carya.tn/src/controllers/mark_car_unavailable.php?id=<?php echo $car->id; ?>'><button>Mark Unavailable</button></a>
                                <?php endif; ?>
                                <!-- Button to trigger popup -->
                                <button id='UpdateCarBtn<?php echo $car->id; ?>'>Update Listing</button>
                                <!-- Agressive Pug : (i added a button to redirect you to a pop up that will have the commands there )-->
                                <button id='ConfirmCommandsBtn<?php echo $car->id; ?>'>Confirm Commands</button>


                            </div>
                    </div>
                </div>

                <!-- Popup -->
                <div id="popup<?php echo $car->id ?>" class="popup-add-container update">
                        <div class="add-titles">
                            <h2>Update Car Listing</h2>
                        </div>
                        <form action="http://localhost/Mini-PHP-Project/carya.tn/src/controllers/update_car.php" method="POST" enctype="multipart/form-data">
                            <div class="form-container">
                                <div class="sub-container">
                                    <label for="brand">Car Brand:</label>
                                    <input type="text" id="brand" name="brand" value="<?php echo $car->brand; ?>">
                                </div>
                                <div class="sub-container">
                                    <label for="model">Car Model:</label>
                                    <input type="text" id="model" name="model" value="<?php echo $car->model; ?>">
                                </div>
                                <div class="sub-container">
                                    <label for="color">Car Color:</label>
                                    <input type="text" id="color" name="color" value="<?php echo $car->color; ?>">
                                </div>
                                <div class="sub-container">
                                    <label for="price">Car Price:</label>
                                    <input type="text" pattern="\d+(\.\d+)?" id="price" name="price" value="<?php echo $car->price; ?>">
                                </div>
                                <div class="sub-container">
                                    <label for="km">Car Kilometers:</label>
                                    <input type="text" pattern="\d+(\.\d+)?" id="km" name="km" value="<?php echo $car->km; ?>">
                                </div>
                                <div class="sub-container file-upload">
                                    <label for='<?php echo "image$car->id" ?>' class="custom-file-upload">
                                        <span class="upload-icon">Upload Image</span>
                                        <input type="file" id='<?php echo "image$car->id" ?>' name="image" onchange='<?php echo "displayFileNameUpdate(this, $car->id)" ?>'>
                                    </label>
                                    <div class="no-file-name">
                                        <p id='<?php echo "update-name{$car->id}" ?>'>No file chosen</p>
                                    </div>
                                </div>
                                <div class="sub-container">
                                    <input type="hidden" id="car_id" name="car_id" value="<?php echo $car->id; ?>">
                                    <input type="submit" class="submit-popup-button" value="Update Car">
                                </div>
                            </div>
                        </form>
                    </div>
                <!-- AggressivePug : Confirm commands Popup -->            
                <div id="commandsPopup<?php echo $car->id ?>" class="popup">
                    <div class="popup-content">
                    <h2>Confirm Commands</h2>
                    <ul> <!-- Start of the list -->
            <?php
            // Fetch rental commands for this car
            $commands = Command::getRentalCommandsByCarId($car->id);
            foreach ($commands as $command) {
                //todo : backend fix this status thing

                if (!isset($command->confirmed)) {
                    $status = "Unreviewed";
                } elseif ($command->confirmed == true) {
                    $status = "accepted";
                } elseif ($command->confirmed == false) {
                    $status = "refused";
                }

                // Display each command as list item
                echo "<li>User: " . $command->user_id . " | Rental Date: " . $command->rental_date . 
                " | Start Date: " . $command->start_date . " | End Date: " . $command->end_date . 
                " | Duration: " . $command->rental_period . " days | Status:  " .$status  ."</li>";
                            
                // Add Accept and Refuse buttons
                echo "<form method='post' action='http://localhost/Mini-PHP-Project/carya.tn/src/controllers/accept_command.php'>";
                echo "<input type='hidden' name='command_id' value='" . $command->command_id . "'>";
                echo "<button type='submit' name='accept'>Accept</button>";
                echo "</form>";
                
                echo "<form method='post' action='http://localhost/Mini-PHP-Project/carya.tn/src/controllers/refuse_command.php'>";
                echo "<input type='hidden' name='command_id' value='" . $command->command_id . "'>";
                echo "<button type='submit' name='refuse'>Refuse</button>";
                echo "</form>";
            }
            ?>
        </ul>
                    </div>
                </div>


            <?php endforeach; ?>
        </div>
    </div>

    

    <!-- Popup content -->
    <div class="popup popup-add-container" id="addCarPopup">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/templates/add_car_form.php'; ?>
    </div>

    <!-- Overlay to cover the background -->
    <div class="overlay" id="overlay"></div>

</body>
</html>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>
