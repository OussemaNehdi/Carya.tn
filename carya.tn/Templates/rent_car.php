 
<!-- // This file will include the fitering menu on the left and the fetching (from Controller folder) on the right
// The filter menu will be compatible with this page as well as the user listing page (More on filter_menu.php)

//todo : edit alignment and style -->

<?php 
$title="Carya.tn";
$class=""
?>

<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/Mini-PHP-Project/CSS/style.css">
    <title>Rental Car Website</title>
    <style>
        .container {
            display: flex;
        }

        .filter-menu {
            width: 30%;
            padding: 20px;
            background-color: #f2f2f2;
        }

        .cars-list {
            width: 70%;
            padding: 20px;
        }
    </style>
</head>
<body class="rent-body">
    <div class="container">
        <div class="filter-menu">
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/Templates/filter_menu.php'; ?>
        </div>
        <div class="cars-list">
            <!-- This is where the fetched cars will be displayed -->
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/Templates/fetch_cars.php'; ?>
        </div>
    </div>
</body>
</html>
<?php $content = ob_get_clean();?>

<?php require('layout.php')?>