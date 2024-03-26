<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="http://localhost/Mini-PHP-Project/CSS/style.css">
    <title>Rent Car</title>
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <?php
    require_once('connect.php');
    $sql = "SELECT * FROM cars";
    $result = $conn->query($sql);
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
                <th>km</th> 
                
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
                    <td><?php echo $car['km']?></td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="showDatePicker(this)">Rent</button>
                        <div class="hidden">
                            <input type="date" id="startDate" onchange="enableConfirmButton()" />
                            <input type="date" id="endDate" onchange="enableConfirmButton()" />
                            <button id="confirmButton" class="btn btn-primary btn-sm" disabled>Confirm</button>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <script>
        function showDatePicker(button) {
            var startDate = button.nextElementSibling;
            startDate.classList.remove("hidden");
        }

        function enableConfirmButton() {
            var startDate = document.getElementById("startDate");
            var endDate = document.getElementById("endDate");
            var confirmButton = document.getElementById("confirmButton");
            confirmButton.disabled = !(startDate.value && endDate.value);
        }
    </script>
</body>
</html>
                    
