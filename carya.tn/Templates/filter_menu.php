<?php 
// A dynamic filter menu that communicates with the database
// This filter menu will be compatible with this page as well as the user listing page



include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/car.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Controllers/dynamic_filter_menu_data.php';

$filter_data = Car::constructFilterQuery($_GET);

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
            <form action="http://localhost/Mini-PHP-Project/carya.tn/src/controllers/filter_controller.php" method="POST">
                <h3>Brand</h3>
                <?php foreach ($brands as $brand): ?>
                    <label><input type="checkbox" name="brand[]" value="<?php echo $brand; ?>" <?php if (isset($filter_data['brand']) && in_array($brand, $filter_data['brand'])) echo 'checked'; ?>><?php echo $brand; ?></label><br>
                <?php endforeach; ?>

                <h3>Model</h3>
                <?php foreach ($models as $model): ?>
                    <label><input type="checkbox" name="model[]" value="<?php echo $model; ?>" <?php if (isset($filter_data['model']) && in_array($model, $filter_data['model'])) echo 'checked'; ?>><?php echo $model; ?></label><br>
                <?php endforeach; ?>

                <h3>Color</h3>
                <?php foreach ($colors as $color): ?>
                    <label><input type="checkbox" name="color[]" value="<?php echo $color; ?>" <?php if (isset($filter_data['color']) && in_array($color, $filter_data['color'])) echo 'checked'; ?>><?php echo $color; ?></label><br>
                <?php endforeach; ?>

                <h3>Kilometers Range</h3>
                <input type="range" id="km_min" name="km_min" min="0" max="<?php echo $max_km; ?>" value="<?php echo isset($filter_data['km_min']) ? $filter_data['km_min'][0] : '0'; ?>"> <span id="km_min_val"><?php echo isset($filter_data['km_min']) ? $filter_data['km_min'][0] : '0'; ?></span> km<br>
                <input type="range" id="km_max" name="km_max" min="0" max="<?php echo $max_km; ?>" value="<?php echo isset($filter_data['km_max']) ? $filter_data['km_max'][0] : $max_km; ?>"> <span id="km_max_val"><?php echo isset($filter_data['km_max']) ? $filter_data['km_max'][0] : $max_km; ?></span> km<br>

                <h3>Price Range</h3>
                <input type="range" id="price_min" name="price_min" min="0" max="<?php echo $max_price; ?>" value="<?php echo isset($filter_data['price_min']) ? $filter_data['price_min'][0] : '0'; ?>"> $<span id="price_min_val"><?php echo isset($filter_data['price_min']) ? $filter_data['price_min'][0] : '0'; ?></span><br>
                <input type="range" id="price_max" name="price_max" min="0" max="<?php echo $max_price; ?>" value="<?php echo isset($filter_data['price_max']) ? $filter_data['price_max'][0] : $max_price; ?>"> $<span id="price_max_val"><?php echo isset($filter_data['price_max']) ? $filter_data['price_max'][0] : $max_price; ?></span><br>
                <input type="submit" value="Apply Filters">
            </form>
        </div>

        
    </div>

    <script>
        // JavaScript code to display current range values
        // TODO : the files are messed up and i couldnt add this to any place add later to a script.js file
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