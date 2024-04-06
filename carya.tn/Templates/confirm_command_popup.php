<div id="commandsPopup<?= $car->id ?>" class="command-popup">
    <div class="main-container">
        <div class="titles">
            <h2>Commands</h2>
        </div>
        <?php if (empty($commands)): ?>
            <p>No commands available</p>
        <?php endif; ?>
        <?php foreach ($commands as $command): ?>
            <div class="sub-container">
                <?php
                // Setting command status
                $status = "Unreviewed";
                if (isset($command->confirmed)) {
                    $status = $command->confirmed ? "accepted" : "refused";
                }
                ?>
                <div class="details">
                    <div class="mini-titles">
                        <span>User:</span>
                        <span>Rental Date:</span>
                        <span>Start Date:</span>
                        <span>End Date:</span>
                        <span>Duration:</span>
                        <span>Status:</span> 
                    </div>
                    <div class="mini-details">
                        <p><?= $user->firstName . " " . $user->lastName?></p>
                        <p><?= $command->rental_date ?></p>
                        <p><?= $command->start_date ?></p>
                        <p><?= $command->end_date ?></p>
                        <p><?= $command->rental_period ?> days</p>
                        <p><?= $status ?></p>
                    </div>
                </div>
                <!-- Accept and Refuse buttons -->
                <?php if (!isset($command->confirmed)) : ?>
                <div class="action-buttons">
                    <form method="post" action="http://localhost/Mini-PHP-Project/carya.tn/src/controllers/accept_command.php">
                        <input type="hidden" name="command_id" value="<?= $command->command_id ?>">
                        <button type="submit" name="accept" class="button-accept">Accept</button>
                    </form>
                    <form method="post" action="http://localhost/Mini-PHP-Project/carya.tn/src/controllers/refuse_command.php">
                        <input type="hidden" name="command_id" value="<?= $command->command_id ?>">
                        <button type="submit" name="refuse" class="button-deny">Refuse</button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
