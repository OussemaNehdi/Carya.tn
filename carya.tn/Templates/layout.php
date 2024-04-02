<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?></title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="http://localhost/Mini-PHP-Project/carya.tn/style.css">
    </head>
    <body class=<?= $class ?>>
        <!-- Start of Navbar -->
        <nav class="navbar">
            <div class="navbar-logo">
                <a href="http://localhost/Mini-PHP-Project/carya.tn/index.php">Carya.tn Logo</a>
            </div>
            <div class="navbar-menu">
                <ul>
                    <div class="basics">
                        <li class="navbar-link"><a href="http://localhost/Mini-PHP-Project/carya.tn/index.php">Home</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">Services</a>
                            <ul class="dropdown-menu">
                                <li><a class="navbar-dropdown-link" href="http://localhost/Mini-PHP-Project/carya.tn/Templates/rent_car.php">Rent a Car</a></li>
                                <li><a class="navbar-dropdown-link" href="http://localhost/Mini-PHP-Project/carya.tn/templates/listing.php">My Cars</a></li>
                            </ul>
                        </li>
                        <?php
                            // check if the user is an admin
                            if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                                echo '<li class="navbar-link"><a href="http://localhost/Mini-PHP-Project/carya.tn/Templates/admin_dashboard.php">Admin Dashboard</a></li>';
                            }
                        ?>
                        <li class="navbar-link"><a href="http://localhost/Mini-PHP-Project/carya.tn/Templates/about.php">About</a></li>
                        <li class="navbar-link"><a href="http://localhost/Mini-PHP-Project/carya.tn/Templates/contact.php">Contact</a></li>
                    </div>
                </ul>
            </div>
            <div class="nav-user">
                <ul>
                    <?php
                        if(isset($_SESSION['user_id'])){
                            $user = User::getUserById($_SESSION['user_id']);
                            echo '<li class="login-button"><a href="http://localhost/Mini-PHP-Project/carya.tn/src/Controllers/logout.php">Logout</a></li>';
                            echo '<li class="profile-button"><a href="http://localhost/Mini-PHP-Project/carya.tn/Templates/profile.php">'.$user->firstName.'</a></li>';
                            echo '</li>';
                        }else{
                            echo '<li class="login-button"><a href="http://localhost/Mini-PHP-Project/carya.tn/Templates/login.php">Login</a></li>';
                        }                    
                    ?>
                </ul>
            </div>
        </nav>
        <!-- End of Navbar -->
        <?php
            // Function to get the appropriate Bootstrap alert class based on the message type
            function getAlertClass($messageType) {
                switch ($messageType) {
                    case 'success':
                        return 'alert-success';
                    case 'error':
                        return 'alert-danger';
                    default:
                        return 'alert-info'; // Default to info if no specific type is provided
                }
            }
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                if (isset($_GET['message'])) {
                    $_message = $_GET['message'];
                    // Determine the alert class based on the message type
                    $alertClass = getAlertClass($_GET['type']);
                    // Display the message using Bootstrap's alert class
                    echo "<div class='alert $alertClass message display' role='alert'>$_message</div>";
                }
            }
        ?>
        <?= $content ?>
        <script src="http://localhost/Mini-PHP-Project/carya.tn/script.js"></script>
    </body>
</html>