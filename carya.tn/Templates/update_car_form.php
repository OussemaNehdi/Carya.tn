<?php 
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $car_id = $_GET['id'];
    $car = Car::getCarById($car_id);

    $owner_id = $car->owner_id;

    if ($owner_id != $_SESSION['user_id']) {
        header('Location: http://localhost/Mini-PHP-Project/');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Car</title>
</head>
<body>
    <form action='<?php echo "http://localhost/Mini-PHP-Project/carya.tn/src/controllers/update_car.php?id=$car_id" ?>' method="POST" enctype="multipart/form-data">
        <label for="brand">Car Brand:</label><br>
        <input type="text" id="brand" name="brand" value="<?php echo $car->brand; ?>"><br>
        <label for="model">Car Model:</label><br>
        <input type="text" id="model" name="model" value="<?php echo $car->model; ?>"><br>
        <label for="color">Car Color:</label><br>
        <input type="text" id="color" name="color" value="<?php echo $car->color; ?>"><br>
        <label for="price">Car Price:</label><br>
        <input type="text" id="price" name="price" value="<?php echo $car->price; ?>"><br>
        <label for="km">Car Kilometers:</label><br>
        <input type="text" id="km" name="km" value="<?php echo $car->km; ?>"><br>
        <label for="image">Upload New Car Image:</label><br>
        <input type="file" id="image" name="image"><br>
        <input type="hidden" id="car_id" name="car_id" value="<?php echo $car->id; ?>">
        <input type="hidden" name="refferer" value="<?php echo isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) : ''; ?>">
        <input type="submit" value="Update Car">
    </form>

</body>
</html>
