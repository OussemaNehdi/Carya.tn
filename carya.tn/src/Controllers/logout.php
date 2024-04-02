<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
session_unset();
session_destroy();
header("Location: http://localhost/Mini-PHP-Project/carya.tn/index.php?message=You%20are%20logged%20out%20successfully.&type=success");
?>