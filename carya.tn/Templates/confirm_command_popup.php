<div id="commandsPopup<?= $car->id ?>" class="popup-add-container update">
    <div>
        <h2>Confirm Commands</h2>
        <ul> <!-- Start of the list -->
            <?php foreach ($commands as $command): ?>
                <?php
                // Setting command status
                $status = "Unreviewed";
                if (isset($command->confirmed)) {
                    $status = $command->confirmed ? "accepted" : "refused";
                }
                ?>
                <li>User: <?= $command->user_id ?> | Rental Date: <?= $command->rental_date ?>
                    | Start Date: <?= $command->start_date ?> | End Date: <?= $command->end_date ?>
                    | Duration: <?= $command->rental_period ?> days | Status: <?= $status ?></li>
                <!-- Accept and Refuse buttons -->
                <form method="post" action="http://localhost/Mini-PHP-Project/carya.tn/src/controllers/accept_command.php">
                    <input type="hidden" name="command_id" value="<?= $command->command_id ?>">
                    <button type="submit" name="accept">Accept</button>
                </form>
                <form method="post" action="http://localhost/Mini-PHP-Project/carya.tn/src/controllers/refuse_command.php">
                    <input type="hidden" name="command_id" value="<?= $command->command_id ?>">
                    <button type="submit" name="refuse">Refuse</button>
                </form>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
