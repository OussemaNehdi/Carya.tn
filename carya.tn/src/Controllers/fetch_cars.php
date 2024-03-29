<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php');


// Get the filter conditions from the URL
if (isset($_GET) && !empty($_GET)) {
    $filters = Car::constructFilterQuery($_GET);
    $cars = Car::getFilteredCars($filters, availability:1);
} else {

    $cars = Car::getAllCars(availability:1);
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/Mini-PHP-Project/CSS/style.css">
    <title>Rental Car Website</title>
    <style>
        .car {
            width: 30%;
            margin: 1%;
            padding: 1%;
            border: 1px solid #ccc;
            display: inline-block;
            vertical-align: top;
        }
        .car img {
            width: 100%;
            height: auto;
        }
        /* Style for the popup */
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 9999;
        }
        .popup-content {
            background-color: white;
            width: 50%;
            margin: 100px auto;
            padding: 20px;
            border-radius: 5px;
            position: relative; /* Ensure position relative for absolute positioning of the close button */
        }
        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body class="rent-body">
    <div class="container">
        <h2>Available Cars</h2>
        <div class="cars-container">
            <?php foreach ($cars as $car): ?>
                <div class="car">
                    <!-- Adjusted to use object properties -->
                    <img src="/Mini-PHP-Project/carya.tn/Resources/car_images/<?php echo $car->image; ?>" alt="<?php echo $car->brand . ' ' . $car->model; ?>">
                    <p><strong><?php echo $car->brand . ' ' . $car->model; ?></strong></p>
                    <p><strong>Color:</strong> <?php echo $car->color; ?></p>
                    <p><strong>Kilometers:</strong> <?php echo $car->km; ?> km</p>
                    <p><strong>Price:</strong> $<?php echo $car->price; ?></p>
                    <button class="rent-button" onclick="showPopup(<?php echo $car->id; ?>)">Rent</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Popup for renting form -->
    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close-button" onclick="closePopup()">X</span>
            <!-- TODO: Add your renting form here -->
            <h2>Renting Form</h2>
            <p>This is where the renting form will be.</p>
        </div>
    </div>

    <script>
        // Function to show popup
        function showPopup(carId) {
            // You can modify this function to load different forms based on carId if needed
            document.getElementById('popup').style.display = 'block';
        }

        // Function to close popup
        function closePopup() {
            document.getElementById('popup').style.display = 'none';
        }

        // Close popup when ESC key is pressed
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closePopup();
            }
        });
    </script>
</body>
</html>
