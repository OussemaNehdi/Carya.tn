<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Command.php');

session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
// Get the filter conditions from the URL
if (isset($_GET) && !empty($_GET)) {
    $filters = Car::constructFilterQuery($_GET);
    $cars = Car::getFilteredCars($filters, available:1);
} else {
    if ($user_id === null) {
        $cars = Car::getAllCars(available:1);
    } else {
        $cars = Car::getAllCars(available:1, owner:$user_id);
    }}
?>

<div class="container">
    <div class="titles">
        <h2>Available Cars</h2>
    </div>
    <div class="cars-container">
    <?php foreach ($cars as $car): ?>
        <div class="car">
            <!-- Adjusted to use object properties -->
            <img src="/Mini-PHP-Project/carya.tn/Resources/car_images/<?php echo $car->image; ?>" alt="<?php echo $car->brand . ' ' . $car->model; ?>">
            <p><strong><?php echo $car->brand . ' ' . $car->model; ?></strong></p>
            <p><strong>Color:</strong> <?php echo $car->color; ?></p>
            <p><strong>Kilometers:</strong> <?php echo $car->km; ?> km</p>
            <p><strong>Price:</strong> $<?php echo $car->price; ?></p>
            <div class="rent-button">
                <?php if ($user_id !== null): ?>
                    <button id="rentCarButton<?php echo $car->id; ?>">Rent</button>
                <?php else: ?>
                    <button><a href="http://localhost/Mini-PHP-Project/carya.tn/Templates/login.php">Login to Rent</a></button>
                <?php endif; ?>
            </div>

        </div>
    <?php endforeach; ?>
    </div>

</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        <?php foreach ($cars as $car): ?>
            document.getElementById("rentCarButton<?php echo $car->id ?>").addEventListener("click", function() {
                // Show the corresponding popup and overlay
                document.getElementById("popup<?php echo $car->id ?>").style.display = "block";
                document.getElementById("overlay").style.display = "block";
            });
        <?php endforeach; ?>

        // Close all popups and overlay when clicking outside the popups
        document.getElementById("overlay").addEventListener("click", function() {
            // Hide all popups and overlay
            <?php foreach ($cars as $car): ?>
                document.getElementById("popup<?php echo $car->id ?>").style.display = "none";
            <?php endforeach; ?>
            document.getElementById("overlay").style.display = "none";
        });
    });
</script>
</html>

<?php foreach ($cars as $car): ?>
    <div id="popup<?php echo $car->id ?>" class="popup-rent-container">
        <div class="popup-titles">
            <h2>Rent Car Form</h2>
        </div>
        <?php
        // Assume $carDetails contains the details of the selected car
        $car = Car::getCarById($car->id);

        // Assume $unavailableDates contains the dates in which the car is unavailable
        $unavailableDates = $car->getUnavailableDates();

        // Get today's date
        $today = date('Y-m-d');

        // Get the minimum and maximum dates for the date picker
        $minDate = $today;
        $maxDate = date('Y-m-d', strtotime('+1 year'));

        // Check if the car details are available
        if (!empty($car)) {
            $html1 = <<<HTML
            <div class="car-details">
                <h3>Car Details:</h3>
                <p>Brand: {$car->brand}</p>
                <p>Model: {$car->model}</p>
                <p>Color: {$car->color}</p>
                <p>Price per Day: \${$car->price}</p>
            </div>
            HTML;

            echo $html1;

            // Display unavailable dates
            if (empty($unavailableDates)) {
                $unavailableDates = ['No unavailable dates'];
            }
            echo "<h3>Unavailable Dates:</h3>";
            foreach ($unavailableDates as $date) {
                echo "<p>$date</p>";
            }

            // Display rent form
            $html2 = <<<HTML
            <h3> Rent Car: </h3>
            <form action="http://localhost/Mini-PHP-Project/carya.tn/src/controllers/rent_car.php?car_id={$car->id}" method="post">
                <div class="sub-container">
                    <div class="label-container">
                        <label for="start_date">Start Date:</label>
                    </div>
                    <input type="date" id="start_date" name="start_date" min="$minDate" max="$maxDate" required>
                </div>
                <div class="sub-container">
                    <div class="label-container">
                        <label for="end_date">End Date:</label>
                    </div>
                    <input type="date" id="end_date" name="end_date" min="$minDate" max="$maxDate" required>
                </div>
                <div class="sub-container">
                    <div class="label-container">
                        <label for="password">Password:</label>
                    </div>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="submit-container">
                    <input type="hidden" name="car_id" value="{$car->id}">
                    <input type="submit" class="submit-popup-button" value="Rent">
                </div>
            </form>
            HTML;
            echo $html2;
        } else {
            echo "<p>No car details available.</p>";
        }
        ?>
    </div>
<?php endforeach; ?>


<!-- Overlay to cover the background -->
<div class="overlay" id="overlay"></div>