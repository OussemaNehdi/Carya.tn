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
        $cars = Car::getAllCars(available:1);
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
    <?php require 'rent_popup.php'; ?>
<?php endforeach; ?>


<!-- Overlay to cover the background -->
<div class="overlay" id="overlay"></div>