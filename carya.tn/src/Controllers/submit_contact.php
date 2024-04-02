<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
}
?>