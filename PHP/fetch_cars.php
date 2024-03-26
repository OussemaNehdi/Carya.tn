<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="http://localhost/Mini-PHP-Project/CSS/style.css">
    <title>Rent Car</title>
</head>
<body>
    <?php
    require_once('connect.php');
    $sql = "SELECT * FROM cars";
    $result = $conn->query($sql);
    $cars=  $result->fetch_assoc();
?>
<h1>Rent a Car</h1>
<p>Choose a car to rent:</p> 
<table class="table table-striped m-0">
        <thead>
        <tr>
          <th>#</th>
          <th>brand</th>
          <th>model</th>
          <th>color</th>
          <th>price</th>

        </tr>
        </thead>
        <tbody>
            <?php while ($car = $result->fetch_assoc()) : ?>
            <tr>
                <th><?php echo $car['id']?> </th>
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