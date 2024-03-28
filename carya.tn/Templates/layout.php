<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?></title>
        
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="http://localhost/Mini-PHP-Project/carya.tn/style.css">
    </head>
    <body>
        <!-- Start of Navbar -->
        <nav class="navbar">
            <div class="container">
                <div class="navbar-brand">
                    <a href="http://localhost/Mini-PHP-Project/carya.tn/index.php">Carya.tn Logo</a>
                </div>
                <div class="navbar-menu">
                    <ul>
                        <div class="basics">
                            <li><a href="http://localhost/Mini-PHP-Project/carya.tn/index.php">Home</a></li>
                            <li><a href="http://localhost/Mini-PHP-Project/carya.tn/Templates/about.php">About</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle">Services</a>
                                <ul class="dropdown-menu">
                                    <li><a href="http://localhost/Mini-PHP-Project/php/rent_car.php">Rent a Car</a></li>
                                    <li><a href="#">List Your Car for Rent</a></li>
                                    <li><a href="#">Export Rent History</a></li>
                                </ul>
                            </li>
                            <li><a href="http://localhost/Mini-PHP-Project/carya.tn/Templates/contact.php">Contact</a></li>
                        </div>
                        <?php
                            if (session_status() == PHP_SESSION_NONE) {
                                session_start();
                            }
                            if(isset($_SESSION['user_id'])){
                                echo '<li class="user">';
                                echo '<li class="login-button"><a href="http://localhost/Mini-PHP-Project/carya.tn/src/Controllers/logout.php">Logout</a></li>';
                                echo '<li class="profile-button"><a href="http://localhost/Mini-PHP-Project/carya.tn/Templates/profile.php">Profile</a></li>';
                                echo '</li>';
                            }else{
                                echo '<li class="login-button"><a href="http://localhost/Mini-PHP-Project/carya.tn/Templates/login.php">Login</a></li>';
                            }                    
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End of Navbar -->

        <?= $content ?>
        <script src="http://localhost/Mini-PHP-Project/carya.tn/script.js"></script>
    </body>
</html>