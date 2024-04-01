
<h2>Add Car</h2>
<form action="http://localhost/Mini-PHP-Project/carya.tn/src/controllers/add_car.php" method="POST" enctype="multipart/form-data">
    <label for="brand">Car Brand:</label><br>
    <input type="text" id="brand" name="brand"><br>
    <label for="model">Car Model:</label><br>
    <input type="text" id="model" name="model"><br>
    <label for="color">Car Color:</label><br>
    <input type="text" id="color" name="color"><br>
    <label for="price">Car Price:</label><br>
    <input type="text" id="price" name="price"><br>
    <label for="km">Car Kilometers:</label><br>
    <input type="text" id="km" name="km"><br>
    <label for="car_image">Car Image:</label><br>
    <input type="file" id="car_image" name="car_image"><br>
    <input type="hidden" name="refferer" value="<?php echo isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) : ''; ?>">
    <input type="submit" value="Add Car">
</form>