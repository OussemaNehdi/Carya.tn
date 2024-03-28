<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent a Car</title>
    <link rel="stylesheet" href="../Resources/style.css">
    <style>
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
<body>
    <h1>Rent a Car</h1>
    <div class="car-container">
        <?php
        require_once('../src/Lib/connect.php');

        // Constructing the SQL query based on filter criteria
        $sql = "SELECT * FROM cars WHERE 1";
/*
        // Filtering by brand
        if (!empty($_GET['brand'])) {
            $brands = implode("','", $_GET['brand']);
            $sql .= " AND brand IN ('$brands')";
        }

        // Filtering by model
        if (!empty($_GET['model'])) {
            $models = implode("','", $_GET['model']);
            $sql .= " AND model IN ('$models')";
        }
        
        // Filtering by color
        if (!empty($_GET['color'])) {
            $colors = implode("','", $_GET['color']);
            $sql .= " AND color IN ('$colors')";
        }

        // Filtering by kilometers range
        if (!empty($_GET['km_min']) || !empty($_GET['km_max'])) {
            $km_min = $_GET['km_min'];
            $km_max = $_GET['km_max'];
            $sql .= " AND km BETWEEN $km_min AND $km_max";
        }

        // Filtering by price range
        if (!empty($_GET['price_min']) || !empty($_GET['price_max'])) {
            $price_min = $_GET['price_min'];
            $price_max = $_GET['price_max'];
            $sql .= " AND price BETWEEN $price_min AND $price_max";
        }*/

        $result = $pdo->query($sql);

        while ($car = $result->fetch(PDO::FETCH_ASSOC)) :
        ?>
        <div class="car">
            <img src="<?php echo '../Resources/car_images/' . $car['image']; ?>" alt="<?php echo $car['brand'] . ' ' . $car['model']; ?>">
            <div class="car-info">
                <div>
                    <p><strong>Brand:</strong> <?php echo $car['brand']; ?></p>
                    <p><strong>Model:</strong> <?php echo $car['model']; ?></p>
                    <p><strong>Color:</strong> <?php echo $car['color']; ?></p>
                    <p><strong>Kilometers:</strong> <?php echo $car['km']; ?></p>
                    <p><strong>Price:</strong> $<?php echo $car['price']; ?></p>
                </div>
                <button class="rent-button" onclick="showPopup(<?php echo $car['id']; ?>)">Rent</button>
            </div>
        </div>
        <?php endwhile; ?>
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
