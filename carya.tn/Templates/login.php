<?php 
$title="Login";
$class = "login-body"; 
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['message'])) {
        $_message = $_GET['message'];
        echo "<script>alert('$_message')</script>";
    }
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        session_unset();
        session_destroy();
    }
}
?>

<?php ob_start(); ?>
<div class="login-container">
    <div class="box">
        <!---------------------------- Login Box ---------------------------->
        <form action="http://localhost/Mini-PHP-Project/carya.tn/src/Controllers/submit_login.php" method="POST">
            <div class="box-login" id="login">
                <div class="top-header">
                    <h3>Hello, Again!</h3>
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
                        <div  class="eye-box" onclick="myLogPassword()">
                        <i class="fa-regular fa-eye" id="eye"></i>
                        <i class="fa-regular fa-eye-slash" id="eye-slash"></i>
                    </div>
                </div>
            </div>
            <!-- this closing div tag is doing magic -->
            </div>
                <div class="remember">
                    <input type="checkbox" id="formCheck" class="check">
                    <label for="formCheck">Remember Me</label>
                </div>
                <div class="input-field">
                    <input type="submit" class="input-submit" value="Sign In" required>
                </div>
                <div class="forgot">
                    <a href="#">Forgot password?</a>
                </div>
            </div>
        </form>
        <!---------------------------- Signup Box ---------------------------->
        <form action="http://localhost/Mini-PHP-Project/carya.tn/src/Controllers/submit_signup.php" method="POST">
            <div class="box-register" id="register">
                <div class="top-header">
                    <h3>Sign Up, Now!</h3>
                    <small>We are happy to have you with us.</small>
                </div>
                <div class="input-group">
                    <div class="input-field">
                        <input type="text" class="input-box" id="regUsername" name="fname" required>
                        <label for="regUsername">First Name</label>
                    </div>
                    <div class="input-field">
                        <input type="text" class="input-box" id="regUsername" name="lname" required>
                        <label for="regUsername">Last Name</label>
                    </div>
                    <div class="input-field">
                        <input type="text" class="input-box" id="regEmail" name="email" required>
                        <label for="regEmail">Email address</label>
                    </div>
                    <div class="input-field">
                        <input type="password" class="input-box" id="regPassword"  name="password" required>
                        <label for="regPassword">Password</label>
                        <div class="eye-area">
                            <div  class="eye-box" onclick="myRegPassword()">
                                <i class="fa-regular fa-eye" id="eye-2"></i>
                                <i class="fa-regular fa-eye-slash" id="eye-slash-2"></i>
                            </div>
                        </div>
                    </div>
                    
                </div>
                    <div class="radio-buttons">
                        <input type="radio" id="formCheck1" name="check1" value="customer" checked>
                        <label for="formCheck1">Customer</label>
                        <input type="radio" id="formCheck2" name="check1" value="seller">
                        <label for="formCheck2">Seller</label>
                    </div>
                    <div class="input-field">
                        <input type="submit" class="input-submit" value="Sign Up" required>
                    </div>
                </div>
                <div class="switch">
                    <a href="#" class="login active" onclick="login()">Login</a>
                    <a href="#" class="register" onclick="register()">Register</a>
                    <div class="btn-active" id="btn"></div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Slide animation -->
<script>//TODO : add js code to js file instead
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
    function login(){
        x.style.left = "27px";
        y.style.right = "-350px";
        z.style.left = "0px";
    }
    function register(){
        x.style.left = "-350px";
        y.style.right = "25px";
        z.style.left = "150px";
    }
// View Password codes
        
    
    function myLogPassword(){
        var a = document.getElementById("logPassword");
        var b = document.getElementById("eye");
        var c = document.getElementById("eye-slash");
        if(a.type === "password"){
        a.type = "text";
        b.style.opacity = "0";
        c.style.opacity = "1";
        }else{
        a.type = "password";
        b.style.opacity = "1";
        c.style.opacity = "0";
        }
    }
    function myRegPassword(){

        var d = document.getElementById("regPassword");
        var b = document.getElementById("eye-2");
        var c = document.getElementById("eye-slash-2");

        if(d.type === "password"){
        d.type = "text";
        b.style.opacity = "0";
        c.style.opacity = "1";
        }else{
        d.type = "password";
        b.style.opacity = "1";
        c.style.opacity = "0";
        }
    }
</script>
    
<?php $content = ob_get_clean();?>

<?php require('layout.php')?>