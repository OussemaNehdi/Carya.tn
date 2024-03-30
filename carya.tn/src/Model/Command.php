<?php
// Include necessary files
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php';

class Command {
    // Properties
    public $command_id;
    public $car_id;
    public $user_id;
    public $rental_date;
    public $start_date;
    public $end_date;
    public $rental_period;
    public $confirmed; //new : Added by AgressivePug 

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

    // Method to get command object from the sql result
    public static function getCommandFromRow($row) {
        return new Command(
            $row['command_id'],
            $row['car_id'],
            $row['user_id'],
            $row['rental_date'],
            $row['start_date'],
            $row['end_date'],
            $row['rental_period']
        );
    }

    // Method to add a rental command
    public static function addRentalCommand($car_id, $user_id, $start_date, $end_date, $rental_period) {
        global $pdo;
        try {
            $sql = "INSERT INTO command (car_id, user_id, start_date, end_date, rental_period) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$car_id, $user_id, $start_date, $end_date, $rental_period]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error adding rental command: " . $e->getMessage());
            throw $e;
        }
    }

    // Method to get all rental commands
    public static function getAllRentalCommands() {
        global $pdo;
        try {
            $sql = "SELECT * FROM command";
            $stmt = $pdo->query($sql);
            $commands = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $command = Command::getCommandFromRow($row);
                $commands[] = $command;
            }
            return $commands;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error fetching all rental commands: " . $e->getMessage());
            throw $e;
        }
    }

    // Method to delete a rental command by ID
    public function deleteRentalCommandById() {
        $commandId = $this->command_id;
        global $pdo;
        try {
            $sql = "DELETE FROM command WHERE command_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$commandId]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error deleting rental command by ID: " . $e->getMessage());
            throw $e;
        }
    }

    // Method to delete a rental command by user ID
    public static function deleteRentalCommandByUserId($userId) {
        global $pdo;
        try {
            $sql = "DELETE FROM command WHERE user_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$userId]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error deleting rental command by user ID: " . $e->getMessage());
            throw $e;
        }
    }

    // Method to get a rental command by ID
    public static function getRentalCommandById($command_id) {
        global $pdo;
        try {
            $sql = "SELECT * FROM command WHERE command_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$command_id]);
            $commandData = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($commandData) {
                $command = Command::getCommandFromRow($commandData);
                return $command;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error fetching rental command by ID: " . $e->getMessage());
            throw $e;
        }
    }

    // Method to get rental commands by user ID
    public static function getRentalCommandsByUserId($user_id) {
        global $pdo;
        try {
            $sql = "SELECT * FROM command WHERE user_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user_id]);
            $commands = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $command = Command::getCommandFromRow($row);
                $commands[] = $command;
            }
            return $commands;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error fetching rental commands by user ID: " . $e->getMessage());
            throw $e;
        }
    }
    public static function getRentalCommandsByCarId($car_id) {
        global $pdo;
        try {
            $sql = "SELECT * FROM command WHERE car_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$car_id]);
            $commands = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $command = Command::getCommandFromRow($row);
                $commands[] = $command;
            }
            return $commands;
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error fetching rental commands by car ID: " . $e->getMessage());
            throw $e;
        }
    }
    public static function AcceptCommand($command_id)
    {
        
        $command = self::getRentalCommandById($command_id);

        if ($command) {
            
            $command->confirmed = true;
            
            
            global $pdo;

            // Prepare the SQL query
            $sql = "UPDATE command SET confirmed = :confirmed WHERE command_id = :command_id";

            // Prepare the statement
            $stmt = $pdo->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':confirmed', $command->confirmed, PDO::PARAM_BOOL);
            $stmt->bindParam(':command_id', $command_id, PDO::PARAM_INT);

            // Execute the statement
            $stmt->execute();
        }
    }
    public static function RefuseCommand($command_id)
    {
        
        $command = self::getRentalCommandById($command_id);

        if ($command) {
            
            $command->confirmed = false;
            
            
            global $pdo;

            // Prepare the SQL query
            $sql = "UPDATE command SET confirmed = :confirmed WHERE command_id = :command_id";

            // Prepare the statement
            $stmt = $pdo->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':confirmed', $command->confirmed, PDO::PARAM_BOOL);
            $stmt->bindParam(':command_id', $command_id, PDO::PARAM_INT);

            // Execute the statement
            $stmt->execute();
        }
    }







}
?>
