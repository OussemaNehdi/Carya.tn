<div class="main-container">
    <div class="add-titles">
        <h2>Add Car</h2>
    </div>
    <form action="http://localhost/Mini-PHP-Project/carya.tn/src/controllers/add_car.php" method="POST" enctype="multipart/form-data">
        <div class="form-container">
            <div class="sub-container">
                <label for="brand">Car Brand:</label>
                <input type="text" id="brand" name="brand" required>
            </div>
            <div class="sub-container">
                <label for="model">Car Model:</label>
                <input type="text" id="model" name="model" required>
            </div>
            <div class="sub-container">    
                <label for="color">Car Color:</label>
                <input type="text" id="color" name="color" required>
            </div>
            <div class="sub-container">
                <label for="price">Car Price:</label>
                <input type="text" id="price" name="price" required>
            </div>
            <div class="sub-container">
                <label for="km">Car Kilometers:</label>
                <input type="text" id="km" name="km" required>
            </div>
            <div class="sub-container1">
                <label for="car_image" class="custom-file-upload">
                    <span class="upload-icon">Upload Image</span>
                    <input type="file" id="car_image" name="car_image" required onchange="displayFileName(this)">
                </label>
                <div class="no-file-name">
                        <span id="file-name">No file chosen</span>
                </div>
            </div>
            <div class="submit-add-popup">
                <input type="hidden" name="refferer" value="<?php echo isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) : ''; ?>">
                <input type="submit" class="submit-popup-button" value="Add Car">
            </div>
        </div>
    </form>
</div>
<script>
    function displayFileName(input) {
    var fileName = input.files[0].name;
    var fileNameElement = document.getElementById("file-name");
    
    if (fileName.length > 20) {
        fileName = fileName.substring(0, 20) + "..."; // Truncate if over 20 characters
    }
    
    fileNameElement.textContent = fileName;
}
</script>