<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Car</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
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
        <input type="submit" value="Add Car">
    </form>
</body>
</html>

<?php 
    include '../connect.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $color = $_POST['color'];
        $price = $_POST['price'];
        $km = $_POST['km'];
        $sql = "INSERT INTO cars (brand, model, color, price, km) VALUES ('$brand', '$model', '$color', '$price', '$km')";
        if (mysqli_query($conn, $sql)) {
            header('Location: index.php');
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
?>