<div id="commandsPopup<?php echo $car->id ?>" class="popup-add-container update">
    <div>
        <h2>Confirm Commands</h2>
        <ul> <!-- Start of the list -->
            <?php
            // Fetch rental commands for this car
            $commands = Command::getRentalCommandsByCarId($car->id);
            foreach ($commands as $command) {
                //a : backend fix this status thing

                if (!isset($command->confirmed)) {
                    $status = "Unreviewed";
                } elseif ($command->confirmed == true) {
                    $status = "accepted";
                } elseif ($command->confirmed == false) {
                    $status = "refused";
                }

                // Display each command as list item
                echo "<li>User: " . $command->user_id . " | Rental Date: " . $command->rental_date . 
                " | Start Date: " . $command->start_date . " | End Date: " . $command->end_date . 
                " | Duration: " . $command->rental_period . " days | Status:  " .$status  ."</li>";
                
                // Add Accept and Refuse buttons
                echo "<form method='post' action='http://localhost/Mini-PHP-Project/carya.tn/src/controllers/accept_command.php'>";
                echo "<input type='hidden' name='command_id' value='" . $command->command_id . "'>";
                echo "<button type='submit' name='accept'>Accept</button>";
                echo "</form>";
                
                echo "<form method='post' action='http://localhost/Mini-PHP-Project/carya.tn/src/controllers/refuse_command.php'>";
                echo "<input type='hidden' name='command_id' value='" . $command->command_id . "'>";
                echo "<button type='submit' name='refuse'>Refuse</button>";
                echo "</form>";
            }
            ?>
        </ul>
    </div>
</div>