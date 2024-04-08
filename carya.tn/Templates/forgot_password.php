<?php 
$title = "Forgot Password";
$class = "forgot-body"; 
?>

<?php ob_start(); ?>
    <form action="http://localhost/Mini-PHP-Project/carya.tn/src/Controllers/submit_forgot.php" method="POST">
        <div class="container">
            <div class="card">
                <i class="fas fa-lock lock-icon"></i>
                <h2>Forgot Password?</h2>
                <p>You can reset your Password here</p>
                <div class="input-field">
                    <input type="email" class="input-box" placeholder="" name="email" required>
                    <label>Email address</label>
                </div>
                <button type="submit">Send My Password</button>
            </div>
        </div>
    </form>
<?php $content = ob_get_clean();?>

<?php require('layout.php')?>