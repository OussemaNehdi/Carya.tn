<?php 
    //this file will include the menu only and the fetching operation will be included from fetch_cars
    require_once('connect.php');
    include 'C:\xampp\htdocs\Mini-PHP-Project\HTML\navbar.php';
    // Fetch distinct values for brands, models, colors, maximum kilometers, and price ranges from the cars table
    $sql_brands = "SELECT DISTINCT brand FROM cars";
    $result_brands = mysqli_query($conn, $sql_brands);
    $brands = [];
    while ($row = mysqli_fetch_assoc($result_brands)) {
        $brands[] = $row['brand'];
    }

    $sql_models = "SELECT DISTINCT model FROM cars";
    $result_models = mysqli_query($conn, $sql_models);
    $models = [];
    while ($row = mysqli_fetch_assoc($result_models)) {
        $models[] = $row['model'];
    }

    $sql_colors = "SELECT DISTINCT color FROM cars";
    $result_colors = mysqli_query($conn, $sql_colors);
    $colors = [];
    while ($row = mysqli_fetch_assoc($result_colors)) {
        $colors[] = $row['color'];
    }

    $sql_max_km = "SELECT MAX(km) AS max_km FROM cars";
    $result_max_km = mysqli_query($conn, $sql_max_km);
    $row_max_km = mysqli_fetch_assoc($result_max_km);
    $max_km = $row_max_km['max_km'];

    $sql_max_price = "SELECT MAX(price) AS max_price FROM cars";
    $result_max_price = mysqli_query($conn, $sql_max_price);
    $row_max_price = mysqli_fetch_assoc($result_max_price);
    $max_price = $row_max_price['max_price'];

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/Mini-PHP-Project/CSS/style.css">
    <title>Rental Car Website</title>
</head>
<body class="rent-body">
    <div class="container">
        <div class="filter-menu">
            <h2>Filter Menu</h2>
            <form action="rent_car.php" method="GET">
                <h3>Brand</h3>
                <?php foreach ($brands as $brand): ?>
                    <label><input type="checkbox" name="brand[]" value="<?php echo $brand; ?>" <?php if (isset($_GET['brand']) && in_array($brand, $_GET['brand'])) echo 'checked'; ?>><?php echo $brand; ?></label><br>
                <?php endforeach; ?>

                <h3>Model</h3>
                <?php foreach ($models as $model): ?>
                    <label><input type="checkbox" name="model[]" value="<?php echo $model; ?>" <?php if (isset($_GET['model']) && in_array($model, $_GET['model'])) echo 'checked'; ?>><?php echo $model; ?></label><br>
                <?php endforeach; ?>

                <h3>Color</h3>
                <?php foreach ($colors as $color): ?>
                    <label><input type="checkbox" name="color[]" value="<?php echo $color; ?>" <?php if (isset($_GET['color']) && in_array($color, $_GET['color'])) echo 'checked'; ?>><?php echo $color; ?></label><br>
                <?php endforeach; ?>

                <h3>Kilometers Range</h3>
                <input type="range" id="km_min" name="km_min" min="0" max="<?php echo $max_km; ?>" value="<?php echo isset($_GET['km_min']) ? $_GET['km_min'] : '0'; ?>"> <span id="km_min_val"><?php echo isset($_GET['km_min']) ? $_GET['km_min'] : '0'; ?></span> km<br>
                <input type="range" id="km_max" name="km_max" min="0" max="<?php echo $max_km; ?>" value="<?php echo isset($_GET['km_max']) ? $_GET['km_max'] : $max_km; ?>"> <span id="km_max_val"><?php echo isset($_GET['km_max']) ? $_GET['km_max'] : $max_km; ?></span> km<br>

                <h3>Price Range</h3>
                <input type="range" id="price_min" name="price_min" min="0" max="<?php echo $max_price; ?>" value="<?php echo isset($_GET['price_min']) ? $_GET['price_min'] : '0'; ?>"> $<span id="price_min_val"><?php echo isset($_GET['price_min']) ? $_GET['price_min'] : '0'; ?></span><br>
                <input type="range" id="price_max" name="price_max" min="0" max="<?php echo $max_price; ?>" value="<?php echo isset($_GET['price_max']) ? $_GET['price_max'] : $max_price; ?>"> $<span id="price_max_val"><?php echo isset($_GET['price_max']) ? $_GET['price_max'] : $max_price; ?></span><br>

                <input type="submit" value="Apply Filters">
            </form>
        </div>

        <div class="car-display">
            <?php require 'fetch_cars.php'; mysqli_close($conn); ?>
        </div>
    </div>

    <script>
        // JavaScript code to display current range values
        document.getElementById('km_min').addEventListener('input', function() {
            document.getElementById('km_min_val').innerText = this.value;
        });
        document.getElementById('km_max').addEventListener('input', function() {
            document.getElementById('km_max_val').innerText = this.value;
        });
        document.getElementById('price_min').addEventListener('input', function() {
            document.getElementById('price_min_val').innerText = this.value;
        });
        document.getElementById('price_max').addEventListener('input', function() {
            document.getElementById('price_max_val').innerText = this.value;
        });
    </script>

</body>
</html>