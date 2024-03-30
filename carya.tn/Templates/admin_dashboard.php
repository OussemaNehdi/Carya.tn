<!-- Monsieur jozf, bch taamel e design juste taa les tableau wel buttons, ey w zid aamel e style taa el popups TAA EL UPDATE WEL ADD, mch el hover, Merci! -->
<!-- Btw, add car form fichier seprate w deja used fel list your car -->

<?php
// Include necessary files
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/controllers/is_admin.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Command.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';

// Set title and class
$title = "Admin Dashboard";
$class = "admin-dashboard";


ob_start();

// Start or resume session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
    <h1>Admin Dashboard</h1>

    <!-- User list -->
    <section>
        <h2>List of Users</h2>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Created</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (User::getAllUsers() as $user) : ?>
                    <tr>
                        <td><?= $user->id ?></td>
                        <td><?= $user->firstName ?></td>
                        <td><?= $user->lastName ?></td>
                        <td><?= $user->email ?></td>
                        <td><?= $user->creation_date ?></td>
                        <td><?= $user->role ?></td>
                        <td>
                            <?php
                            // Shows ban/unban or admin status based on the user's role

                            if ($user->role == 'banned') {
                                echo "<a href=\"http://localhost/Mini-PHP-Project/carya.tn/src/controllers/unban_user.php?id={$user->id}\" class='unban-link'>Unban</a>";
                            } else if ($user->role == 'admin') {
                                echo "Admin";
                            } else {
                                echo "<a href=\"http://localhost/Mini-PHP-Project/carya.tn/src/controllers/ban_user.php?id={$user->id}\" class='ban-link'>Ban</a>";
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <!-- Car list -->
    <section>
        <h2>List of Cars</h2>
        <table>
            <thead>
                <tr>
                    <th>Car ID</th>
                    <th>Car Brand</th>
                    <th>Car Model</th>
                    <th>Color</th>
                    <th>Kilometers</th>
                    <th>Owner</th>
                    <th>Price</th>
                    <th>Available</th>
                    <th>Actions</th>
                    <th><button id="addCarBtn">Add Car</button></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (Car::getAllCars() as $car) : ?>
                    <tr>
                        <td class='car-image' data-id='<?= $car->id ?>'><?= $car->id ?></td>
                        <td class='car-image' data-id='<?= $car->id ?>'><?= $car->brand ?></td>
                        <td class='car-image' data-id='<?= $car->id ?>'><?= $car->model ?></td>
                        <td><?= $car->color ?></td>
                        <td><?= $car->km ?></td>
                        <td class='user-info' data-id='<?= $car->owner_id ?>'><?= $car->owner_id ?></td>
                        <td><?= $car->price ?></td>
                        <td><?= $car->isCarAvailable() ? "Yes" : "No" ?></td>
                        <td>
                            <?php
                            // Show delete and update buttons based on the car's availability and ownership

                            if ($car->isCarAvailable()) {
                                echo "<a href='http://localhost/Mini-PHP-Project/carya.tn/src/controllers/delete_car.php?id={$car->id}'>Delete</a>";
                                
                            ?>
                        </td>
                        <td>
                            <?php
                                if ($car->owner_id == $_SESSION['user_id']) {
                                    echo "<button id='UpdateCarBtn{$car->id}'>Update Listing</button>";
                                }
                            }
                            ?>
                            <!-- 3raftch chna3mel bech e tableau ykoun kemel khtr kn challa9t el add button hatitou f th donc lzm td zeyda uwu -->
                        </td>
                    </tr>

                    <!-- Popup For the update car form -->
                    <!-- each car gets a hidden div for its popup but the logic is the same -->
                    <div id="popup<?php echo $car->id ?>" class="popup">
                        <div class="popup-content">
                            <h2>Update Car Listing</h2>
                            <form action="http://localhost/Mini-PHP-Project/carya.tn/src/controllers/update_car.php" method="POST" enctype="multipart/form-data">
                                <label for="brand">Car Brand:</label><br>
                                <input type="text" id="brand" name="brand" value="<?php echo $car->brand; ?>"><br>
                                <label for="model">Car Model:</label><br>
                                <input type="text" id="model" name="model" value="<?php echo $car->model; ?>"><br>
                                <label for="color">Car Color:</label><br>
                                <input type="text" id="color" name="color" value="<?php echo $car->color; ?>"><br>
                                <label for="price">Car Price:</label><br>
                                <input type="text" id="price" name="price" value="<?php echo $car->price; ?>"><br>
                                <label for="km">Car Kilometers:</label><br>
                                <input type="text" id="km" name="km" value="<?php echo $car->km; ?>"><br>
                                <label for="image">Upload New Car Image:</label><br>
                                <input type="file" id="image" name="image"><br>
                                <input type="hidden" id="car_id" name="car_id" value="<?php echo $car->id; ?>">
                                <input type="submit" value="Update Car">
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <!-- Car commands list -->
    <section>
        <h2>List of Car Commands</h2>
        <table>
            <thead>
                <tr>
                    <th>Command ID</th>
                    <th>Car ID</th>
                    <th>User ID</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Price Paid</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (Command::getAllRentalCommands() as $command) : ?>
                    <?php
                    // Get car and user information for the current command
                    $car = Car::getCarById($command->car_id);
                    $user = User::getUserById($command->user_id);
                    $price_paid = $car->price * $command->rental_period;
                    ?>
                    <tr>
                        <td><?= $command->command_id ?></td>
                        <td class='car-info' data-id='<?= $car->id ?>'><?= $car->id ?></td>
                        <td class='user-info' data-id='<?= $user->id ?>'><?= $user->id ?></td>
                        <td><?= $command->start_date ?></td>
                        <td><?= $command->end_date ?></td>
                        <td><?= $price_paid ?></td>
                        <td>
                            <a href="http://localhost/Mini-PHP-Project/carya.tn/src/controllers/cancel_command.php?id=<?= $command->command_id ?>" class='unban-link'>Cancel Command</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>


    <div id="info-popup" class="info-popup"></div>

    <!-- Overlay to cover the background -->
    <div class="overlay" id="overlay"></div>

    <!-- Popup content -->
    <!-- Popup taa el add -->
    <div class="popup" id="addCarPopup">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/templates/add_car_form.php'; ?>
    </div>


    <script>
        // Function to fetch and display user or car information
        function displayInfo(type, id) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("info-popup").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "http://localhost/Mini-PHP-Project/carya.tn/src/controllers/fetch_info.php?type=" + type + "&id=" + id, true);
            xmlhttp.send();
        }

        // Event listener for hovering over user ID or car ID
        document.querySelectorAll('.user-info, .car-info, .car-image').forEach(item => {
    item.addEventListener('click', event => {
        const type = event.target.classList.contains('user-info') ? 'user' : event.target.classList.contains('car-image') ? 'image' : 'car';
        const id = event.target.getAttribute('data-id');
        displayInfo(type, id);
        document.getElementById('info-popup').style.display = 'block';
        document.getElementById('info-popup').style.left = event.pageX + 'px';
        document.getElementById('info-popup').style.top = (event.pageY + 20) + 'px';
        event.stopPropagation(); // Prevent the click event from propagating to the document body
    });
});

// Add event listener to the document body to close the popup when clicked outside
document.body.addEventListener('click', event => {
    const infoPopup = document.getElementById('info-popup');
    if (infoPopup.style.display === 'block' && !infoPopup.contains(event.target)) {
        infoPopup.style.display = 'none';
    }
});

        document.getElementById("addCarBtn").addEventListener("click", function() {
            // Show the popup and overlay
            document.getElementById("addCarPopup").style.display = "block";
            document.getElementById("overlay").style.display = "block";
        });

        <?php
        $user_id = $_SESSION['user_id'];
        $user = User::getUserById($user_id);
        $cars = $user->getCarsByOwnerId();
        ?>
        document.addEventListener("DOMContentLoaded", function() {
            // Add event listener to each "Update Listing" button
            <?php foreach ($cars as $car) : ?>
                document.getElementById("UpdateCarBtn<?php echo $car->id ?>").addEventListener("click", function() {
                    // Show the corresponding popup and overlay
                    document.getElementById("popup<?php echo $car->id ?>").style.display = "block";
                    document.getElementById("overlay").style.display = "block";
                });
            <?php endforeach; ?>

            // Close all popups and overlay when clicking outside the popups
                    
            document.getElementById("overlay").addEventListener("click", function() {
                // Hide all popups and overlay
                <?php foreach ($cars as $car) : ?>
                    document.getElementById("popup<?php echo $car->id ?>").style.display = "none";
                <?php endforeach; ?>
                document.getElementById("addCarPopup").style.display = "none";
                document.getElementById("overlay").style.display = "none";
            });
        });
    </script>
<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>