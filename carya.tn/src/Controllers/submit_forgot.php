<?php
// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/vendor/autoload.php';
require $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the email address from the form
    $email = $_POST["email"];

    // Query the database to retrieve the user's password based on the provided email address
    $user= User::getUserByEmail($email);
    $password = $user->password;

    // Check if a password is found for the provided email address
    if ($password) {
        // Send an email with the user's password
        sendEmail($email, $password);

        // Redirect the user to a success page or display a success message
        header("Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/forgot_password.php?message=Success&type=success");
        exit;
    } else {
        // If no password is found, redirect the user to an error page or display an error message
        header("Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/forgot_password.php?message=Error!&type=error");
        exit;
    }
}

// Function to send an email with the user's password
function sendEmail($email, $password) {
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // SMTP settings for Mailtrap (replace with your Mailtrap settings)
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = 'username';
        $mail->Password = 'password';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 2525;

        // Email content
        $mail->setFrom('caryatnwebsite@gmail.com', 'CARYA.TN SUPPORT');
        $mail->addAddress($email);
        $mail->Subject = 'Your Password Recovery';
        $mail->Body = "Your password is: $password"; // its sending the hashed password to the email which is a problem I can't get my head around

        // Send the email
        $mail->send();
    } catch (Exception $e) {
        // Handle exception if the email fails to send
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>