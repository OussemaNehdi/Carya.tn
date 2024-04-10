<?php
// This PHP file defines a class 'Command' and related methods to manage rental commands in a database.

// Include necessary files
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php';

/**
 * Represents a command object with properties and methods to manage command data in a database.
 */
class Command {
    /**
     * The ID of the rental command.
     *
     * @var int
     */
    public $command_id;

    /**
     * The ID of the car associated with the rental command.
     *
     * @var int
     */
    public $car_id;

    /**
     * The ID of the user who made the rental command.
     *
     * @var int
     */
    public $user_id;

    /**
     * The date when the rental command was made.
     *
     * @var string
     */
    public $rental_date;

    /**
     * The start date of the rental period.
     *
     * @var string
     */
    public $start_date;

    /**
     * The end date of the rental period.
     *
     * @var string
     */
    public $end_date;

    /**
     * The duration of the rental period.
     *
     * @var string
     */
    public $rental_period;

    /**
     * Indicates whether the rental command is confirmed.
     *
     * @var bool
     */
    public $confirmed;

    /**
     * Constructor method for the Command class.
     *
     * @param int $command_id The ID of the rental command.
     * @param int $car_id The ID of the car associated with the rental command.
     * @param int $user_id The ID of the user who made the rental command.
     * @param string $rental_date The date when the rental command was made.
     * @param string $start_date The start date of the rental period.
     * @param string $end_date The end date of the rental period.
     * @param int $rental_period The duration of the rental period.
     * @param bool $confirmed Indicates whether the rental command is confirmed.
     */
    public function __construct($command_id, $car_id, $user_id, $rental_date, $start_date, $end_date, $rental_period, $confirmed) {
        $this->command_id = $command_id;
        $this->car_id = $car_id;
        $this->user_id = $user_id;
        $this->rental_date = $rental_date;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->rental_period = $rental_period;
        $this->confirmed = $confirmed; 
    }

    /**
     * Method to create a Command object from a row fetched from the database.
     *
     * @param array $row The associative array representing a row fetched from the database.
     * @return Command The Command object created from the database row.
     */
    public static function getCommandFromRow($row) {
        return new Command(
            $row['command_id'],
            $row['car_id'],
            $row['user_id'],
            $row['rental_date'],
            $row['start_date'],
            $row['end_date'],
            $row['rental_period'],
            $row['confirmed'] //new : Added by AgressivePug
        );
    }

    /**
     * Method to add a rental command to the database.
     *
     * @param int $car_id The ID of the car for the rental command.
     * @param int $user_id The ID of the user making the rental command.
     * @param string $start_date The start date of the rental period.
     * @param string $end_date The end date of the rental period.
     * @param int $rental_period The duration of the rental period in days.
     * @return bool True if the rental command was successfully added, false otherwise.
     * @throws PDOException If an error occurs during the database operation.
     */
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

    /**
     * Method to retrieve a rental command by its ID from the database.
     *
     * @param int $command_id The ID of the rental command to retrieve.
     * @return Command|null The Command object if found, or null if not found.
     * @throws PDOException If an error occurs during the database operation.
     */
    public static function getCommandById($command_id) {
        global $pdo;
        try {
            $sql = "SELECT * FROM command WHERE command_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$command_id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return Command::getCommandFromRow($row);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            // Log error and rethrow the exception
            error_log("Error fetching command by ID: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Method to retrieve all rental commands from the database.
     *
     * @return array An array of Command objects representing all rental commands.
     * @throws PDOException If an error occurs during the database operation.
     */
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

    /**
     * Method to delete a rental command from the database by its ID.
     *
     * @return bool True if the rental command was successfully deleted, false otherwise.
     * @throws PDOException If an error occurs during the database operation.
     */
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

    /**
     * Method to delete rental commands from the database by user ID.
     *
     * @param int $userId The ID of the user whose rental commands are to be deleted.
     * @return bool True if rental commands were successfully deleted, false otherwise.
     * @throws PDOException If an error occurs during the database operation.
     */
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

    /**
     * Method to retrieve a rental command from the database by its ID.
     *
     * @param int $command_id The ID of the rental command to retrieve.
     * @return Command|null The Command object if found, or null if not found.
     * @throws PDOException If an error occurs during the database operation.
     */
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

    /**
     * Method to retrieve rental commands from the database by user ID.
     *
     * @param int $user_id The ID of the user whose rental commands are to be retrieved.
     * @return array An array of Command objects representing the rental commands associated with the user.
     * @throws PDOException If an error occurs during the database operation.
     */
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

    /**
     * Method to retrieve rental commands from the database by car ID.
     *
     * @param int $car_id The ID of the car whose rental commands are to be retrieved.
     * @return array An array of Command objects representing the rental commands associated with the car.
     * @throws PDOException If an error occurs during the database operation.
     */
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

    /**
     * Method to accept a rental command in the database.
     *
     * @param int $command_id The ID of the rental command to accept.
     * @throws PDOException If an error occurs during the database operation.
     */
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

    /**
     * Method to refuse a rental command in the database.
     *
     * @param int $command_id The ID of the rental command to refuse.
     * @throws PDOException If an error occurs during the database operation.
     */
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
