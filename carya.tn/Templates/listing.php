<?php
// Include necessary files
// Last commit by AgressivePug to add the commands management functionality
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Command.php';

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

// Set title and class
$title = "My Cars";
$class = "listing-body";

ob_start();
?>
<div class="main-container">
    <div class="filter-menu" id="filterMenuContainer">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/Templates/filter_menu.php'; ?>
    </div>
    <div class="cars-list content-container">
        <div class="container">
            <div class="header-container">
                <h2>My Car Listings</h2>
                <button id="addCarBtn">Add Car</button>
            </div>
            <?php foreach ($cars as $car): ?>
                <div class="car-listing-container">
                    <div class="car-image">
                        <img src="/Mini-PHP-Project/carya.tn/Resources/car_images/<?php echo $car->image; ?>" alt="Car Image">
                    </div>
                    <div class="car-details">
                        <h2><?php echo $car->brand . ' ' . $car->model; ?></h2>
                        <p class="car-model"><?php echo $car->model; ?></p>
                        <div class="paragraphs">
                            <p><span class="mini-title">Color:</span> <?php echo $car->color; ?></p>
                            <p><span class="mini-title">Price:</span> <?php echo $car->price; ?></p>
                            <p><span class="mini-title">Kilometers:</span> <?php echo $car->km; ?></p>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <a href='http://localhost/Mini-PHP-Project/carya.tn/src/controllers/delete_car.php?id=<?php echo $car->id; ?>'><button>Delete Listing</button></a>
                        <?php if ($car->isCarMarkedUnavailable()): ?>
                            <a href='http://localhost/Mini-PHP-Project/carya.tn/src/controllers/mark_car_available.php?id=<?php echo $car->id; ?>'><button>Mark Available</button></a>
                        <?php else: ?>
                            <a href='http://localhost/Mini-PHP-Project/carya.tn/src/controllers/mark_car_unavailable.php?id=<?php echo $car->id; ?>'><button>Mark Unavailable</button></a>
                        <?php endif; ?>
                        <!-- Button to trigger popup -->
                        <a href="#"><button id='UpdateCarBtn<?php echo $car->id; ?>'>Update Listing</button></a>
                        <!-- Agressive Pug : (i added a button to redirect you to a pop up that will have the commands there )-->
                        <a href="#"><button id='ConfirmCommandsBtn<?php echo $car->id; ?>'>Confirm Commands</button></a>
                    </div>
                </div>
            <?php endforeach; ?>                
        </div>
    </div>
</div>

<?php foreach ($cars as $car): ?>
<?php require('update_form.php'); ?>
<?php require('confirm_command_popup.php'); ?>
<?php endforeach; ?>

<!-- Popup content -->
<div class="popup-add-container" id="addCarPopup">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/templates/add_car_form.php'; ?>
</div>

<!-- Overlay to cover the background -->
<div class="overlay" id="overlay"></div>

<script>
    window.addEventListener('scroll', function() {
    var filterMenuContainer = document.getElementById('filterMenuContainer');
    var contentContainer = document.querySelector('.content-container');
    var scrollY = window.scrollY || window.pageYOffset;

    if (scrollY > contentContainer.offsetTop) {
        filterMenuContainer.style.top = (scrollY - contentContainer.offsetTop) + 'px';
    } else {
        filterMenuContainer.style.top = '0';
    }
    });

    // Changed by AgressivePug
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

        function displayFileNameUpdate(input, id) {
        
        var fileName = input.files[0].name;
        var fileNameElement = document.getElementById('update-name' + id);
        if (fileName.length > 20) {
            fileName = fileName.substring(0, 20) + "..."; // Truncate if over 20 characters
        }
        fileNameElement.textContent = fileName;
        }
</script>
<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>
