<?php 
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
    <title>Rental Car Website</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
        }

        .filter-menu {
            width: 30%;
            padding: 20px;
            background-color: #f2f2f2;
        }

        .car-display {
            width: 70%;
            padding: 20px;
        }

        h2 {
            margin-top: 0;
        }

        h3 {
            margin-bottom: 5px;
        }

        input[type="checkbox"] {
            margin-right: 5px;
        }

        input[type="range"] {
            width: 100%;
            margin-bottom: 10px;
        }

        span.value {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="filter-menu">
        <h2>Filter Menu</h2>
        <form action="your_php_script.php" method="GET"> <!-- Change your_php_script.php to your actual PHP script -->
            <h3>Brand</h3>
            <?php foreach ($brands as $brand): ?>
                <label><input type="checkbox" name="brand[]" value="<?php echo $brand; ?>"><?php echo $brand; ?></label><br>
            <?php endforeach; ?>

            <h3>Model</h3>
            <?php foreach ($models as $model): ?>
                <label><input type="checkbox" name="model[]" value="<?php echo $model; ?>"><?php echo $model; ?></label><br>
            <?php endforeach; ?>

            <h3>Color</h3>
            <?php foreach ($colors as $color): ?>
                <label><input type="checkbox" name="color[]" value="<?php echo $color; ?>"><?php echo $color; ?></label><br>
            <?php endforeach; ?>

            <h3>Kilometers Range</h3>
            <input type="range" id="km_min" name="km_min" min="0" max="<?php echo $max_km; ?>" value="0"> <span id="km_min_val">0</span> km<br>
            <input type="range" id="km_max" name="km_max" min="0" max="<?php echo $max_km; ?>" value="<?php echo $max_km; ?>"> <span id="km_max_val"><?php echo $max_km; ?></span> km<br>

            <h3>Price Range</h3>
            <input type="range" id="price_min" name="price_min" min="0" max="<?php echo $max_price; ?>" value="0"> $<span id="price_min_val">0</span><br>
            <input type="range" id="price_max" name="price_max" min="0" max="<?php echo $max_price; ?>" value="<?php echo $max_price; ?>"> $<span id="price_max_val"><?php echo $max_price; ?></span><br>

            <input type="submit" value="Apply Filters">
        </form>
    </div>

    <div class="car-display">
        <h2>Available Cars</h2>
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
