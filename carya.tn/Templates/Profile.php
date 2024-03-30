<?php
// Include database connection and any necessary libraries
require_once('../src/Lib/connect.php');

include '../src/Model/Car.php';
include '../src/Model/Command.php';
include '../src/Model/User.php';

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
$currentDate = "2024-04-06";

$activeRentingCars = array_filter($activeRentingCars, function($car) use ($currentDate) {
    return $currentDate >= $car->start_date && $currentDate <= $car->end_date;
});






?>
<?php 
$title="User Profile";
$class="profile-body"
?>

<?php ob_start(); ?>
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle mt-5" width="150px" src="https://www.w3schools.com/howto/img_avatar2.png">
                    <span class="font-weight-bold"><?php echo $userInfo->firstName.' '.$userInfo->lastName;?></span>
                    <span class="text-black-50"><?php echo $userInfo->email;?></span>
                    <span class="text-black-50"><?php echo $userInfo->country . "/" . $userInfo->state;?></span>
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
                            <input type="text" class="form-control" placeholder="first name" value="" name="fname"></div>
                            
                            <div class="col-md-6"><label class="labels">Last name</label>
                            <input type="text" class="form-control" value="" placeholder="last name" name="lname"></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6"><label class="labels">Country</label><input type="text" class="form-control" placeholder="country" name="country" value=""></div>
                            <div class="col-md-6"><label class="labels">State/Region</label><input type="text" class="form-control" name="state" value="" placeholder="state"></div>
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
                        <div class="export-button" onclick="redirectToLink('http://localhost/Mini-PHP-Project/carya.tn/Templates/Export_rent_history.php')">
                            <i class="fas fa-file-export"></i>
                            <a class="link" href="#">Export Rent History</a>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12">
                        <?php if ($activeRentingCars): ?>
                        <h2>Active Renting Cars</h2>
                        <ul>
                            <?php foreach ($activeRentingCars as $car): ?>
                                <li><?php echo $car->car_id . ' ' . $car->car_model. ' | '. "Remaining Days: " . date_diff(date_create($currentDate), date_create($car->end_date))->format('%a'); ?></li>
                            
                                <!-- Add more car details as needed -->
                            <?php endforeach; ?>
                        </ul>   
                        <?php else: ?>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<?php $content = ob_get_clean();?>

<?php require('layout.php')?>