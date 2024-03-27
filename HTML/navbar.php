<nav class="navbar">
    <div class="container">
        <div class="navbar-brand">
            <a href="http://localhost/Mini-PHP-Project/">Carya.tn Logo</a>
        </div>
        <div class="navbar-menu">
            <ul>
                <div class="basics">
                    <li><a href="http://localhost/Mini-PHP-Project/">Home</a></li>
                    <li><a href="http://localhost/Mini-PHP-Project/HTML/about.php">About</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle">Services</a>
                        <ul class="dropdown-menu">
                            <li><a href="http://localhost/Mini-PHP-Project/php/rent_car.php">Rent a Car</a></li>
                            <li><a href="#">List Your Car for Rent</a></li>
                            <li><a href="#">Export Rent History</a></li>
                        </ul>
                    </li>
                    <li><a href="http://localhost/Mini-PHP-Project/HTML/contact.php">Contact</a></li>
                </div>
                <?php
                    if(isset($_SESSION['user_id'])){
                        echo '<li class="user">';
                        echo '<li class="login-button"><a href="http://localhost/Mini-PHP-Project/PHP/logout.php">Logout</a></li>';
                        echo '<li><a href="http://localhost/Mini-PHP-Project/php/profile.php">Profile</a></li>';
                        echo '</li>';
                    }else{
                        echo '<li class="login-button"><a href="http://localhost/Mini-PHP-Project/HTML/login.php">Login</a></li>';
                    }
                ?>
            </ul>
        </div>
    </div>
</nav>