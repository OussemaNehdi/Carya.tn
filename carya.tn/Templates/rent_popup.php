<div id="popup<?php echo $car->id ?>" class="popup-rent-container">
        <div class="popup-titles">
            <h2>Rent Car Form</h2>
        </div>
        <?php
        // Assume $carDetails contains the details of the selected car
        $car = Car::getCarById($car->id);

        // Assume $unavailableDates contains the dates in which the car is unavailable
        $unavailableDates = $car->getUnavailableDates();

        // Get today's date
        $today = date('Y-m-d');

        // Get the minimum and maximum dates for the date picker
        $minDate = $today;
        $maxDate = date('Y-m-d', strtotime('+1 year'));

        // Check if the car details are available
        if (!empty($car)) {
            $html1 = <<<HTML
            <div class="car-details">
                <h3>Car Details:</h3>
                <p>Brand: {$car->brand}</p>
                <p>Model: {$car->model}</p>
                <p>Color: {$car->color}</p>
                <p>Price per Day: \${$car->price}</p>
            </div>
            HTML;

            echo $html1;

            // Display unavailable dates
            if (empty($unavailableDates)) {
                $unavailableDates = ['No unavailable dates'];
            }
            echo "<h3>Unavailable Dates:</h3>";
            foreach ($unavailableDates as $date) {
                echo "<p>$date</p>";
            }

            // Display rent form
            $html2 = <<<HTML
            <h3> Rent Car: </h3>
            <form action="http://localhost/Mini-PHP-Project/carya.tn/src/controllers/rent_car.php?car_id={$car->id}" method="post">
                <div class="sub-container">
                    <div class="label-container">
                        <label for="start_date">Start Date:</label>
                    </div>
                    <input type="date" id="start_date" name="start_date" min="$minDate" max="$maxDate" required>
                </div>
                <div class="sub-container">
                    <div class="label-container">
                        <label for="end_date">End Date:</label>
                    </div>
                    <input type="date" id="end_date" name="end_date" min="$minDate" max="$maxDate" required>
                </div>
                <div class="sub-container">
                    <div class="label-container">
                        <label for="password">Password:</label>
                    </div>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="submit-container">
                    <input type="hidden" name="car_id" value="{$car->id}">
                    <input type="submit" class="submit-popup-button" value="Rent">
                </div>
            </form>
            HTML;
            echo $html2;
        } else {
            echo "<p>No car details available.</p>";
        }
        ?>
    </div>