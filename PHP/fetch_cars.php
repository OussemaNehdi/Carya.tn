<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="http://localhost/Mini-PHP-Project/CSS/style.css">
    <title>Rent Car</title>
</head>
<body>
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
    
    ?>
    <h1>Rent a Car</h1>
    <p>Choose a car to rent:</p> 
    <table class="table table-striped m-0">
        <thead>
            <tr>
                <th>#</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Color</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($car = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $car['id']?> </td>
                    <td><?php echo $car['brand']?></td>
                    <td><?php echo $car['model']?></td>
                    <td><?php echo $car['color']?></td>
                    <td><?php echo $car['price']?></td>
                    <td><button class="btn btn-primary btn-sm">Rent</button></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
