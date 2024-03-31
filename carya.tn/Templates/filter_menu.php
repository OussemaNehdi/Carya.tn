<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/car.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Controllers/dynamic_filter_menu_data.php';

$filter_data = Car::constructFilterQuery($_GET);

// Function to generate input checkboxes
function generateInputCheckboxes($data, $filterData, $filterName) {
    foreach ($data as $item): ?>
        <label>
            <!-- Check if the checkbox is checked or not -->
            <input type="checkbox" name="<?php echo $filterName; ?>[]" value="<?php echo $item; ?>" <?php echo isChecked($item, $filterData, $filterName); ?>>
            <?php echo $item; ?>
        </label><br>
    <?php endforeach;
}

// Function to generate range inputs
function generateRangeInput($id, $name, $min, $max, $value, $filterData) {
    ?>
    <!-- Uses the range selected by the user and displays it -->
    <input class="price-range-slider" type="range" id="<?php echo $id; ?>" name="<?php echo $name; ?>" min="<?php echo $min; ?>" max="<?php echo $max; ?>" value="<?php echo isset($filterData[$name]) ? $filterData[$name][0] : $value; ?>" oninput="updateRangeValue('<?php echo $id; ?>', '<?php echo $id; ?>_val', this.value)"> 
    <span id="<?php echo $id; ?>_val"><?php echo isset($filterData[$name]) ? $filterData[$name][0] : $value; ?></span>
    <?php
}

// Function to check if a checkbox is checked
function isChecked($value, $filterData, $filterName) {
    if (isset($filterData[$filterName]) && in_array($value, $filterData[$filterName])) {
        return 'checked';
    }
    return '';
}
?>

<div class="container">
    <div class="titles">
        <h2>Filter Menu</h2>
    </div>
    <form action="http://localhost/Mini-PHP-Project/carya.tn/src/controllers/filter_controller.php" method="POST">
        <div class="sub-container">
            <h3>Brand</h3>
            <?php generateInputCheckboxes($brands, $filter_data, 'brand'); ?>
        </div>
        <div class="sub-container">
            <h3>Model</h3>
            <?php generateInputCheckboxes($models, $filter_data, 'model'); ?>
        </div>

        <div class="sub-container">
            <h3>Color</h3>
            <?php generateInputCheckboxes($colors, $filter_data, 'color'); ?>
        </div>

        <div class="sub-container">
            <h3>Km Range</h3>
            <?php generateRangeInput('km_min', 'km_min', 0, $max_km, 0, $filter_data); ?> <span>km</span><br>
            <?php generateRangeInput('km_max', 'km_max', 0, $max_km, $max_km, $filter_data); ?> <span>km</span><br>
        </div>

        <div class="sub-container">
            <h3>Price Range</h3>
            <?php generateRangeInput('price_min', 'price_min', 0, $max_price, 0, $filter_data); ?><span>$</span><br>
            <?php generateRangeInput('price_max', 'price_max', 0, $max_price, $max_price, $filter_data); ?><span>$</span><br>
            <input class="apply-button" type="submit" value="Apply Filters">
        </div>
    </form>
</div>
<script>
    function updateRangeValue(rangeId, spanId, newValue) {
        document.getElementById(spanId).innerText = newValue;
    }
</script>
