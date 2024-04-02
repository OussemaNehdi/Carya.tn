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

$to = "caryatnwebsite@gmail.com"; // password: caryatn123

// Subject of the email
$subject = "New Contact Form Submission";

// Email content
$email_content = "Name: $name\n";
$email_content .= "Email: $email\n\n";
$email_content .= "Message:\n$message\n";

$headers = "From: $name <$email>";

// Send email
if (mail($to, $subject, $email_content, $headers)) {
    // Email sent successfully
    header("Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/contact.php?message=success&type=success");
    exit();
} else {
    // Error sending email
    header("Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/contact.php?message=error&type=error");
    exit();
}
?>