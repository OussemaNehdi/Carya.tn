<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php'; // Include the file with database connection

class Command {
    // Properties
    public $command_id;
    public $car_id;
    public $user_id;
    public $rental_date;
    public $start_date;
    public $end_date;
    public $rental_period;

    // Constructor
    public function __construct($command_id, $car_id, $user_id, $rental_date, $start_date, $end_date, $rental_period) {
        $this->command_id = $command_id;
        $this->car_id = $car_id;
        $this->user_id = $user_id;
        $this->rental_date = $rental_date;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->rental_period = $rental_period;
    }

    // Method to get all rental commands
    public static function getAllRentalCommands() {
        global $pdo; // Use the database connection from connect.php
        $sql = "SELECT * FROM command";
        $stmt = $pdo->query($sql);
        $commands = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $command = new Command(
                $row['command_id'],
                $row['car_id'],
                $row['user_id'],
                $row['rental_date'],
                $row['start_date'],
                $row['end_date'],
                $row['rental_period']
            );
            $commands[] = $command; // Store each Command object
        }
        return $commands;
    }
    


    // Method to delete a rental command by ID
    public static function deleteRentalCommandById($commandId) {
        global $pdo; // Use the database connection from connect.php
        $sql = "DELETE FROM rental_commands WHERE command_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$commandId]);
        // Check if any rows were affected (rental command deleted)
        return $stmt->rowCount() > 0;
    }

    public static function isCarAvailable($car_id, $current_date) {
        global $pdo; // Use the database connection from connect.php
        $car_commanded_sql = "SELECT * FROM command WHERE car_id=? AND start_date <= ? AND end_date >= ?";
        $car_commanded_stmt = $pdo->prepare($car_commanded_sql);
        $car_commanded_stmt->execute([$car_id, $current_date, $current_date]);
        $car_commanded = $car_commanded_stmt->fetchAll(PDO::FETCH_ASSOC);
        $available = count($car_commanded) == 0;
        return $available;
    }

}

?>
