<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Command.php';


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$refferer = isset($_POST['refferer']) ? parse_url($_POST['refferer'], PHP_URL_PATH) : (isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) : 'http://localhost/Mini-PHP-Project/carya.tn/index.php');
$command_id = $_POST['command_id'];

Command::AcceptCommand($command_id);

header("Location: $refferer?message=Command%20Accepted%20.");


?>