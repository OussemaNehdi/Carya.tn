<?php 
// this file will give the dynamic filter menu the data it needs

include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/car.php';
// Fetch distinct values for brands, models, colors, maximum kilometers, and price ranges from the cars table
$brands = Car::getDistinctValues('brand');
$models = Car::getDistinctValues('model');
$colors = Car::getDistinctValues('color');
$max_km = Car::getMaxValue('km');
$max_price = Car::getMaxValue('price');
?>