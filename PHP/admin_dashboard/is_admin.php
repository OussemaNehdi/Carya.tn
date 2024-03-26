<?php
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
        header('Location: http://localhost/Mini-PHP-Project/');
        exit();
    }
?>