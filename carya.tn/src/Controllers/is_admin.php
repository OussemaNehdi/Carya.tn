<?php
    // check if the user is an admin
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
        header('Location: http://localhost/Mini-PHP-Project/carya.tn');
        exit();
    }
?>