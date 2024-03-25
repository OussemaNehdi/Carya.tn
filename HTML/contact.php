<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="http://localhost/Mini-PHP-Project/CSS/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="contact_container">
        <h2>Contact Us</h2>
        <?php
        // Check if there is a success or error message in the URL
        if (isset($_GET['success'])) {
            if ($_GET['success'] == 'true') {
                echo '<p class="success">Your message has been sent successfully. We will get back to you soon!</p>';
            } elseif ($_GET['success'] == 'false') {
                echo '<p class="error">Oops! There was an error sending your message. Please try again later.</p>';
            }
        }
        ?>
        <p>We'd love to hear from you! Please fill out the form below to get in touch with us.</p>
        
        <form action="submit_contact.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>
            
            <button type="submit">Send Message</button>
        </form>
    </div>
</body>
</html>