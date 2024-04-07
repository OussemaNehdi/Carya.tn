<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); // Method Not Allowed
    exit("Method Not Allowed");
}

// Check if all required parameters are set
if (!isset($_POST["name"]) || !isset($_POST["email"]) || !isset($_POST["message"])) {
    // Redirect with an error message if any required parameter is missing
    header("Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/contact.php?message=Missing%20required%20parameters%20for%20submitting%20contact%20form.&type=error");
    exit();
}

// Get form data
$name = $_POST["name"];
$email = $_POST["email"];
$message = $_POST["message"];

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/vendor/autoload.php';

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

try {
    // Server settings
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "sandbox.smtp.mailtrap.io";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 2525;
    $mail->Username = "6927bce30c0b5f";
    $mail->Password = "5e96cdabb2c21e";

    // Sender and recipient settings
    $mail->setFrom($email, $name);
    $mail->addAddress("caryatnwebsite@gmail.com", "Mehdi");

    // Set email subject
    $mail->Subject = "Contact form submission";

    // Set email body content
    $mail->Body = "Hello Carya.tn,\n\n$message\n\nBest regards,\n$name";

    // Send email
    $mail->send();
    header("Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/contact.php?message=success&type=success");
    exit();
} catch (Exception $e) {
    header("Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/contact.php?message=error&type=error");
    exit();
}
?>