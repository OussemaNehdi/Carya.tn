<?php


require_once('../src/Lib/connect.php');
include '../src/Model/Car.php';
include '../src/Model/Command.php';
include '../src/Model/User.php';

$user_id=1; //todo : hhhhhhhh 4 rjel ylawjo nharin fin l erreur al star hetha
$rentingHistory = Command::getRentalCommandsByUserId($user_id);

$user=User::getUserById($user_id);   


foreach ($rentingHistory as &$row) {
    
    $carDetails = Car::getCarById($row->car_id);
    $row->car_id = $carDetails->brand;
    $row->car_model = $carDetails->model;
    $row->car_price = $carDetails->price;
}

unset($row);








$html = '<style>';
$html .= 'table {';
$html .= '    width: 100%;';
$html .= '    border-collapse: collapse;';
$html .= '}';
$html .= 'th, td {';
$html .= '    padding: 8px;';
$html .= '    text-align: left;';
$html .= '    border-bottom: 1px solid #ddd;';
$html .= '}';
$html .= 'th {';
$html .= '    background-color: #f2f2f2;';
$html .= '}';
$html .= '</style>';

$html .= '<table>';
$html .= '<tr>';
$html .= '<th>Rent ID</th>';
$html .= '<th>Brand</th>';
$html .= '<th>Model</th>';
$html .= '<th>Rental Date</th>';
$html .= '<th>Start Date</th>';
$html .= '<th>End Date</th>';
$html .= '<th>Price</th>';
$html .= '</tr>';

foreach ($rentingHistory as $row) {
    $html .= '<tr>';
    $html .= '<td>' . $row->command_id . '</td>';
    $html .= '<td>' . $row->car_id . '</td>';
    $html .= '<td>' . $row->car_model . '</td>';  

    $html .= '<td>' . $row->rental_date . '</td>';
    $html .= '<td>' . $row->start_date . '</td>';
    $html .= '<td>' . $row->end_date . '</td>';
    $html .= '<td>' . $row->car_price . '</td>';
    $html .= '</tr>';
}

$html .= '</table>';


echo $html;

?>

<html>
    <head>
        <title>renting button</title>  
    </head>
    <body>
        
    <button > <a href="http://localhost/Mini-PHP-Project/carya.tn/src/Controllers/Download_Rent_History.php">Download</a></button>
    </body>
</html>
