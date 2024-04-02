<!-- Popup For the update car form -->
<!-- each car gets a hidden div for its popup but the logic is the same -->
<div id="popup<?php echo $car->id ?>" class="popup-add-container update">
    <div class="add-titles">
        <h2>Update Car Listing</h2>
    </div>
    <form action="http://localhost/Mini-PHP-Project/carya.tn/src/controllers/update_car.php" method="POST" enctype="multipart/form-data">
        <div class="form-container">
            <div class="sub-container">
                <label for="brand">Car Brand:</label>
                <input type="text" id="brand" name="brand" value="<?php echo $car->brand; ?>">
            </div>
            <div class="sub-container">
                <label for="model">Car Model:</label>
                <input type="text" id="model" name="model" value="<?php echo $car->model; ?>">
            </div>
            <div class="sub-container">
                <label for="color">Car Color:</label>
                <input type="text" id="color" name="color" value="<?php echo $car->color; ?>">
            </div>
            <div class="sub-container">
                <label for="price">Car Price:</label>
                <input type="text" pattern="\d+(\.\d+)?" id="price" name="price" value="<?php echo $car->price; ?>">
            </div>
            <div class="sub-container">
                <label for="km">Car Kilometers:</label>
                <input type="text" pattern="\d+(\.\d+)?" id="km" name="km" value="<?php echo $car->km; ?>">
            </div>
            <div class="sub-container file-upload">
                <label for='<?php echo "image$car->id" ?>' class="custom-file-upload">
                    <span class="upload-icon">Upload Image</span>
                    <input type="file" id='<?php echo "image$car->id" ?>' name="image" onchange='<?php echo "displayFileNameUpdate(this, $car->id)" ?>'>
                </label>
                <div class="no-file-name">
                    <p id='<?php echo "update-name{$car->id}" ?>'>No file chosen</p>
                </div>
            </div>
            <div class="sub-container">
                <input type="hidden" id="car_id" name="car_id" value="<?php echo $car->id; ?>">
                <input type="submit" class="submit-popup-button" value="Update Car">
            </div>
        </div>
    </form>
</div>