<?php
// Include database connection and any necessary libraries
require_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php';

include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Command.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Get the user ID from the URL
$user_id = $_SESSION['user_id'];

// Get the user information
$userInfo = User::getUserById($user_id);

// Get the active renting cars for the user
$activeRentingCars = Command::getRentalCommandsByUserId($user_id);
foreach ($activeRentingCars as &$row) {
    $carDetails = Car::getCarById($row->car_id);
    $row->car_id = $carDetails->brand;
    $row->car_model = $carDetails->model;
    $row->car_price = $carDetails->price;
}

unset($row);

// Filter the active renting cars by dates
$currentDate = date('Y-m-d');

$activeRentingCars = array_filter($activeRentingCars, function ($car) use ($currentDate) {
    return $currentDate >= $car->start_date && $currentDate <= $car->end_date;
});

$activeRentingCars = array_filter($activeRentingCars, function ($car)  {
    return $car->confirmed=="1";
});
?>
<?php
$title = "User Profile";
$class = "profile-body"
?>

<?php ob_start(); ?>
<div class="container rounded mt-5 mb-5 container">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <div class="profile-pic-container">
                    <?php
                    // Check if the user has a profile image
                    if ($userInfo->profile_image) {
                        echo '<img id="profile-img" class="profile-pic" src="http://localhost/Mini-PHP-Project/carya.tn/Resources/profile_images/' . $userInfo->profile_image . '" onclick="document.getElementById(\'upload-profile-img\').click();">';                
                    } else {
                        echo '<img id="profile-img" class="profile-pic" src="https://www.w3schools.com/howto/img_avatar2.png" onclick="document.getElementById(\'upload-profile-img\').click();">';
                    }
                    ?>
                    <i class="fas fa-edit fa-2x edit-icon"></i>
                </div>
                <span class="font-weight-bold"><?php echo $userInfo->firstName . ' ' . $userInfo->lastName; ?></span>
                <span class="text-black-50"><?php echo $userInfo->email; ?></span>
                <span class="text-black-50"><?php echo $userInfo->country . "/" . $userInfo->state; ?></span>

                <!-- Hidden input field for image upload -->
                <form id="upload-form" action="http://localhost/Mini-PHP-Project/carya.tn/src/controllers/profile_image_handler.php" method="POST" enctype="multipart/form-data" style="display: none;">
                    <input type="file" accept="image/*" id="upload-profile-img" name="profile_image" onchange="handleImageUpload(this)">
                </form>

                <!-- Buttons for confirmation and cancellation -->
                <div id="upload-buttons" style="display: none;">
                    <div class="mt-3">
                        <button class="btn btn-primary" onclick="document.getElementById('upload-form').submit();">Upload</button>
                        <button class="btn btn-secondary" onclick="cancelImageUpload()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">My Profile Settings</h4>
                </div>
                <form action="http://localhost/Mini-PHP-Project/carya.tn/src/Controllers/submit_profile.php" method="POST">
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels">First name</label>
                            <input type="text" class="form-control" placeholder="first name" value="" name="fname">
                        </div>

                        <div class="col-md-6"><label class="labels">Last name</label>
                            <input type="text" class="form-control" value="" placeholder="last name" name="lname">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6"><label class="labels">Country</label><input type="text" class="form-control" placeholder="country" name="country" value=""></div>
                        <div class="col-md-6"><label class="labels">State/Region</label><input type="text" class="form-control" name="state" value="" placeholder="state"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Email</label><input type="text" class="form-control" placeholder="Enter email" value="" name="email"></div>

                    </div>
                        <div class="mt-5 text-center">
                        <button class="btn btn-primary profile-save-button" type="submit">Save Profile</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 py-5">
                <div class="export">
                    <button class="export-button" id="export">
                        <i class="fas fa-file-export"></i>
                        <a class="link" href="#">Export Rent History</a>
                    </button>
                </div>
                <br>
                <div class="col-md-12">
                    <?php if ($activeRentingCars) : ?>
                        <h2>Active Renting Cars</h2>
                        <ul>
                            <?php foreach ($activeRentingCars as $car) : ?>
                                <li><?php echo $car->car_id . ' ' . $car->car_model . ' | ' . "Remaining Days: " . date_diff(date_create($currentDate), date_create($car->end_date))->format('%a'); ?></li>

                                <!-- Add more car details as needed -->
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p>No active renting cars at the moment.</p>
                    <?php endif; ?>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div class="export-popup" id="popup">
    <?php include 'Export_rent_history.php'; ?>
</div>
<div class="overlay" id="overlay"></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Add event listener for "Update Listing" button
        document.getElementById("export").addEventListener("click", function() {
            document.getElementById("popup").style.display = "block";
            document.getElementById("overlay").style.display = "block";
        });

        // Add event listener to close popups and overlay when clicking outside popups
        document.getElementById("overlay").addEventListener("click", function() {
            document.getElementById("popup").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        });
    });
    // Function to handle image upload
    function handleImageUpload(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                // Show upload buttons
                document.getElementById('upload-buttons').style.display = "block";
                // Display the selected image as a preview
                document.getElementById('profile-img').src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Function to cancel image upload
    function cancelImageUpload() {
        // Hide upload buttons
        document.getElementById('upload-buttons').style.display = "none";
        // Clear the file input field
        document.getElementById('upload-form').reset();
        // Restore the old profile image if exists
        <?php if ($userInfo->profile_image) : ?>
            document.getElementById('profile-img').src = "http://localhost/Mini-PHP-Project/carya.tn/Resources/profile_images/<?php echo $userInfo->profile_image; ?>";
        <?php else : ?>
            document.getElementById('profile-img').src = "https://www.w3schools.com/howto/img_avatar2.png";
        <?php endif; ?>
    }
</script>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>