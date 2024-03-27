<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['message'])) {
        $_message = $_GET['message'];
        echo "<script>alert('$_message')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="http://localhost/Mini-PHP-Project/CSS/style.css">
</head>

<body class="login-body">
    <?php include 'navbar.php'; ?>
    <div class="login-container">
        <div class="box">
            <!------------- Login box ------------->
            <form action="http://localhost/Mini-PHP-Project/PHP/submit_login.php" method="POST">
                <div class="box-login" id="login">
                    <div class="top-header">
                        <h3>Hello, Again</h3>
                        <small>We are happy to have you back.</small>
                    </div>
                    <div class="input-group">
                        <div class="input-field">
                            <input type="text" class="input-box" id="logEmail" name="email" required>
                            <label for="logEmail">Email address</label>
                        </div>
                        <div class="input-field">
                            <input type="password" class="input-box" id="logPassword" name="password" required>
                            <label for="logPassword">Password</label>
                            <div class="eye-area">
                                <div class="eye-box" onclick="myLogPassword()">
                                    <i class="fa-regular fa-eye" id="eye"></i>
                                    <i class="fa-regular fa-eye-slash" id="eye-slash"></i>
                                </div>
                            </div>
                        </div>
                        <div class="remember">
                            <input type="checkbox" id="formCheck" class="check">
                            <label for="formCheck">Remember me</label>
                        </div>
                        <div class="input-field">
                            <input type="submit" class="input-submit" value="Sign In">
                        </div>
                        <div class="forgot">
                            <a href="#">Forgot password?</a>
                        </div>
                    </div>
            </form>
        </div>

        <!------------- Sign up box ------------->
        <div class="box-register" id="register">
            <form action="http://localhost/Mini-PHP-Project/PHP/submit_signup.php" method="POST">
                <div class="top-header">
                    <h3>Sign Up, Now</h3>
                    <small>We are happy to have you with us.</small>
                </div>
                <div class="input-group">
                    <div class="input-field">
                        <input type="text" class="input-box" id="regFname" name="fname" required>
                        <label for="regFname">First Name</label>
                    </div>
                    <div class="input-field">
                        <input type="text" class="input-box" id="regLname" name="lname" required>
                        <label for="regLname">Last Name</label>
                    </div>
                    <div class="input-field">
                        <input type="text" class="input-box" id="regEmail" name="email" required>
                        <label for="regEmail">Email address</label>
                    </div>
                    <div class="input-field">
                        <input type="password" class="input-box" id="regPassword" name="password" required>
                        <label for="regPassword">Password</label>
                        <div class="eye-area">
                            <div class="eye-box" onclick="myRegPassword()">
                                <i class="fa-regular fa-eye" id="eye-2"></i>
                                <i class="fa-regular fa-eye-slash" id="eye-slash-2"></i>
                            </div>
                        </div>
                    </div>
                    <div class="remember">
                        <input type="radio" id="formCheck1" name="check1" value="customer" checked>
                        <label for="formCheck1">customer</label> &nbsp; &nbsp;
                        <input type="radio" id="formCheck2" name="check1" value="seller">
                        <label for="formCheck2">seller</label>
                    </div>
                    <div class="input-field">
                        <input type="submit" class="input-submit" value="Sign Up">
                    </div>
                </div>
            </form>
        </div>

        <!------------- Switch slide ------------->
        <div class="switch">
            <a href="#" class="login" onclick="login()">Login</a>
            <a href="#" class="register" onclick="register()">Register</a>
            <div class="btn-active" id="btn"></div>
        </div>
    </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var slide = '<?php echo isset($_GET["slide"]) ? $_GET["slide"] : "login"; ?>';
            // Set the initial slide based on the query parameter
            if (slide === 'register') {
                register(); // If the query parameter is "register", show the register slide
            } else {
                login(); // Otherwise, show the login slide (default)
            }
        });

        var x = document.getElementById('login');
        var y = document.getElementById('register');
        var z = document.getElementById('btn');

        function login() {
            x.style.left = "27px";
            y.style.right = "-350px";
            z.style.left = "0px";
        }

        function register() {
            x.style.left = "-350px";
            y.style.right = "25px";
            z.style.left = "150px";
        }

        // View Password codes for login and register
        function myLogPassword() {
            var a = document.getElementById("logPassword");
            var b = document.getElementById("eye");
            var c = document.getElementById("eye-slash");
            if (a.type === "password") {
                a.type = "text";
                b.style.opacity = "0";
                c.style.opacity = "1";
            } else {
                a.type = "password";
                b.style.opacity = "1";
                c.style.opacity = "0";
            }
        }
        function myRegPassword() {

            var d = document.getElementById("regPassword");
            var b = document.getElementById("eye-2");
            var c = document.getElementById("eye-slash-2");

            if (d.type === "password") {
                d.type = "text";
                b.style.opacity = "0";
                c.style.opacity = "1";
            } else {
                d.type = "password";
                b.style.opacity = "1";
                c.style.opacity = "0";
            }
        }
    </script>
</body>

</html>