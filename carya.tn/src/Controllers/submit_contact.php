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

require $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

try {
    // Server settings
    $mail = new PHPMailer(true);
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.gmail.com"; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->Username = "caryatnwebsite@gmail.com";
    $mail->Password = "caryatn123";

    // Sender and recipient settings
    $mail->setFrom($email, $name);
    $mail->addAddress("caryatnwebsite@gmail.com", "Mehdi");

    // Set email subject
    $mail->Subject = "Subject of your email";

    // Set email body content
    $mail->Body = "Hello $name,\n\nThank you for your message:\n$message\n\nBest regards,\nYour Name";

    // Send email
    $mail->send();
    echo "Email sent successfully.";
} catch (Exception $e) {
    // Handle errors
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


?>