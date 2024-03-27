<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Car</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">
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
        <input type="submit" value="Add Car">
    </form>
</body>
</html>

<?php 
    include './connect.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $color = $_POST['color'];
        $price = $_POST['price'];
        $km = $_POST['km'];
        $owner_id = $_SESSION['user_id'];

        $target_directory = "../Resources/Images/car_images/";
        $target_file = $target_directory . basename($_FILES["car_image"]["name"]);
        $uploadOk = 1; 
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); 

        // Check if file is a valid image
        $check = getimagesize($_FILES["car_image"]["tmp_name"]);
        if($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["car_image"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow only certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // Upload the file
            if (move_uploaded_file($_FILES["car_image"]["tmp_name"], $target_file)) {
                $target_file = basename($_FILES["car_image"]["name"]);
                $sql = "INSERT INTO cars (brand, model, color, price, km, image, owner_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$brand, $model, $color, $price, $km, $target_file, $owner_id]);
                header('Location: http://localhost/Mini-PHP-Project/PHP/admin_dashboard/');
                exit();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
?>
