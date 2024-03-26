<?php
// Include the database connection file
require_once('connect.php');

// SQL query to select car name and type
$sql = "SELECT brand, model, color, image, km, price, owner_id, availability FROM cars";

// Execute query
$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Output data of each row using a while loop
    while($row = $result->fetch_assoc()) {
        echo "Brand: " . $row["brand"]. " - Model: " . $row["model"]. " - Color: " . $row["color"]. " - Image: " . $row["image"]. " - KM: " . $row["km"]. " - Price: " . $row["price"]. " - Owner ID: " . $row["owner_id"]. " - Availability: " . $row["availability"]. "<br>";
    }
} else {
    echo "0 results";
}

// Close the database connection
$conn->close();
?>
