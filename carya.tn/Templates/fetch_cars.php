<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Command.php');

session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
// Get the filter conditions from the URL
if (isset($_GET) && !empty($_GET)) {
    $filters = Car::constructFilterQuery($_GET);
    $cars = Car::getFilteredCars($filters, availability:1);
} else {
    if ($user_id === null) {
        $cars = Car::getAllCars(availability:1);
    } else {
        $cars = Car::getAllCars(availability:1, owner:$user_id);
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
    <div id="popup<?php echo $car->id ?>" class="popup">
        <h2>Rent Car Form</h2>
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
            echo "<h3>Car Details:</h3>";
            echo "<p>Brand: {$car->brand}</p>";
            echo "<p>Model: {$car->model}</p>";
            echo "<p>Color: {$car->color}</p>";
            echo "<p>Price per Day: \${$car->price}</p>";

            // Display unavailable dates
            if (empty($unavailableDates)) {
                $unavailableDates = ['No unavailable dates'];
            }
            echo "<h3>Unavailable Dates:</h3>";
            echo "<p>";
            foreach ($unavailableDates as $date) {
                echo "$date" . "<br>";
            }
            echo "</p>";

            // Display rent form
            echo "<h3>Rent Car:</h3>";
            echo "<form action=\"http://localhost/Mini-PHP-Project/carya.tn/src/controllers/rent_car.php\" method=\"post\">";
            echo "<label for=\"start_date\">Start Date:</label>";
            echo "<input type=\"date\" id=\"start_date\" name=\"start_date\" min=\"$minDate\" max=\"$maxDate\" required>";
            echo "<br>";
            echo "<label for=\"end_date\">End Date:</label>";
            echo "<input type=\"date\" id=\"end_date\" name=\"end_date\" min=\"$minDate\" max=\"$maxDate\" required>";
            echo "<br>";
            echo "<label for=\"password\">Password:</label>";
            echo "<input type=\"password\" id=\"password\" name=\"password\" required>";
            echo "<br>";
            echo "<input type=\"hidden\" name=\"car_id\" value=\"{$car->id}\">";
            echo "<input type=\"submit\" value=\"Rent\">";
            echo "</form>";
        } else {
            echo "<p>No car details available.</p>";
        }
        ?>
    </div>
<?php endforeach; ?>


<!-- Overlay to cover the background -->
<div class="overlay" id="overlay"></div>