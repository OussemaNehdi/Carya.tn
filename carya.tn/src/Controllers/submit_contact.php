<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    
    $to = "website@gmail.com"; //this email needs to change to the email you want to receive the contact form submissions
    
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
        header("Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/contact.php?success=true");
        exit();
    } else {
        // Error sending email
        header("Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/contact.php?success=false");
        exit();
    }
}
?>