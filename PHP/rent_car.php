
<?php
//TODO : edit front-end

// Include the database connection file
require_once('connect.php');

// SQL query to select car name and type
//TODO : change names
$sql = "SELECT car_name, car_type FROM cars";

// Execute query
$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Output data of each row using a while loop
    while($row = $result->fetch_assoc()) {
        echo "Car Name: " . $row["car_name"]. " - Car Type: " . $row["car_type"]. "<br>";
    }
} else {
    echo "0 results";
}

// Close the database connection
$conn->close();
?>