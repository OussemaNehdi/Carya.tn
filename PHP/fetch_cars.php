<!-- TODO : change the design to fit with the website theme-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent a Car</title>
    <link rel="stylesheet" href="http://localhost/Mini-PHP-Project/CSS/style.css">
</head>
<body>
    <h1>Rent a Car</h1>
    <div class="car-container">
        <?php
        require_once('connect.php');

        // Constructing the SQL query based on filter criteria
        $sql = "SELECT * FROM cars WHERE 1";

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
        }

        $result = $conn->query($sql);

        while ($car = $result->fetch_assoc()) :
        ?>
        <div class="car">
            <img src="<?php echo 'http://localhost/Mini-PHP-Project/Resources/Images/car_images/' . $car['image']; ?>" alt="<?php echo $car['brand'] . ' ' . $car['model']; ?>">
            <div class="car-info">
                <div>
                    <p><strong>Brand:</strong> <?php echo $car['brand']; ?></p>
                    <p><strong>Model:</strong> <?php echo $car['model']; ?></p>
                    <p><strong>Color:</strong> <?php echo $car['color']; ?></p>
                    <p><strong>Kilometers:</strong> <?php echo $car['km']; ?></p>
                    <p><strong>Price:</strong> $<?php echo $car['price']; ?></p>
                </div>
                <button class="rent-button">Rent</button>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <script>
        // JavaScript code for renting button functionality (if needed)
        // You can add JavaScript code here for handling the renting functionality
    </script>
</body>
</html>
