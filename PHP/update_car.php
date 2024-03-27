<?php 
    include 'connect.php';
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $car_id = $_GET['id'];
        $sql = "SELECT * FROM cars WHERE id=$car_id";
        $car = mysqli_query($conn, $sql);
        $car = mysqli_fetch_assoc($car);

        $owner_id = $car['owner_id'];

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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <label for="brand">Car Brand:</label><br>
        <input type="text" id="brand" name="brand" value="<?php echo $car['brand']; ?>"><br>
        <label for="model">Car Model:</label><br>
        <input type="text" id="model" name="model" value="<?php echo $car['model']; ?>"><br>
        <label for="color">Car Color:</label><br>
        <input type="text" id="color" name="color" value="<?php echo $car['color']; ?>"><br>
        <label for="price">Car Price:</label><br>
        <input type="text" id="price" name="price" value="<?php echo $car['price']; ?>"><br>
        <label for="km">Car Kilometers:</label><br>
        <input type="text" id="km" name="km" value="<?php echo $car['km']; ?>"><br>
        <input type="hidden" id="car_id" name="car_id" value="<?php echo $car['id']; ?>">
        <input type="submit" value="Update Car">
    </form>

</body>
</html>

<?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $car_id = $_POST['car_id'];
        $sql = "SELECT * FROM cars WHERE id=$car_id";
        $car = mysqli_query($conn, $sql);
        $car = mysqli_fetch_assoc($car);

        $owner_id = $car['owner_id'];

        if ($owner_id != $_SESSION['user_id']) {
            header('Location: http://localhost/Mini-PHP-Project/');
        }

        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $color = $_POST['color'];
        $price = $_POST['price'];
        $km = $_POST['km'];
        $sql = "UPDATE cars SET brand='$brand', model='$model', color='$color', price='$price', km='$km' WHERE id=$car_id";
        if (mysqli_query($conn, $sql)) {
            header('Location: http://localhost/Mini-PHP-Project?message=Car updated successfully!');
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
?>