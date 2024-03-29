<?php require_once('../../../Resources/TCPDF-main/tcpdf.php');


require_once('../Lib/connect.php');
include '../Model/Car.php';
include '../Model/Command.php';
include '../Model/User.php';

$user_id=1;
$rentingHistory = Command::getRentalCommandsByUserId($user_id);

$user=User::getUserById($user_id);   


foreach ($rentingHistory as &$row) {
    
    $carDetails = Car::getCarById($row->car_id);
    $row->car_id = $carDetails->brand;
    $row->car_model = $carDetails->model;
    $row->car_price = $carDetails->price;
}

unset($row);







$pdf = new TCPDF(); 

// Set document information
$pdf->SetCreator('Your Name');
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Renting History');
$pdf->SetSubject('Renting History');

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Add a title
$pdf->Cell(0, 10, 'Renting History', 0, 1, 'C');
$pdf->Cell(0, 10, 'for :'.$user->firstName .' '. $user->lastName, 0, 1, 'C');

// Add a table with the renting history data
$header = array('Rent ID', 'Brand',  'Rental Date', 'Start Date', 'End Date', 'Price');
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.3);
$pdf->SetFont('', 'B');
foreach ($header as $column) {
    $pdf->Cell(30, 7, $column, 1, 0, 'C', 1);
}
$pdf->Ln();
$pdf->SetFont('');
$pdf->SetFillColor(224, 235, 255);
$pdf->SetTextColor(0);
$pdf->SetFont('');
$fill = false;
foreach ($rentingHistory as $row) {
    $pdf->Cell(30, 6, $row->command_id, 'LR', 0, 'C', $fill);
    $pdf->Cell(30, 6, $row->car_id ."-".$row->car_model , 'LR', 0, 'C', $fill);
    $pdf->Cell(30, 6, $row->rental_date, 'LR', 0, 'C', $fill);
    $pdf->Cell(30, 6, $row->start_date, 'LR', 0, 'C', $fill);
    $pdf->Cell(30, 6, $row->end_date, 'LR', 0, 'C', $fill);
    $pdf->Cell(30, 6, $row->car_price, 'LR', 0, 'C', $fill);
    $pdf->Ln();
    $fill = !$fill;
}



$pdf->Output('renting_history.pdf', 'D');


?>