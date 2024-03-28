<?php
// Include TCPDF library
require_once('../../Resources/TCPDF-main/tcpdf.php');
require_once('../src/Lib/connect.php');

// Fetch the renting history for the user from the "commands" table
$query = 'SELECT * FROM command WHERE user_id = :user_id';
$userId = 1; // Replace with the actual user ID
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$rentingHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Create a new PDF instance
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

// Add a table with the renting history data
$header = array('Rent ID', 'Brand', 'Rental Date', 'Start Date', 'End Date');
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.3);
$pdf->SetFont('', 'B');
$pdf->Cell(30, 7, $header[0], 1, 0, 'C', 1);
$pdf->Cell(30, 7, $header[1], 1, 0, 'C', 1);
$pdf->Cell(40, 7, $header[2], 1, 0, 'C', 1);
$pdf->Cell(40, 7, $header[3], 1, 0, 'C', 1);
$pdf->Cell(40, 7, $header[4], 1, 1, 'C', 1);
$pdf->SetFont('');
$pdf->SetFillColor(224, 235, 255);
$pdf->SetTextColor(0);
$pdf->SetFont('');
$fill = false;
foreach ($rentingHistory as $row) {
    $pdf->Cell(30, 6, $row['command_id'], 'LR', 0, 'L', $fill);
    $pdf->Cell(30, 6, $row['car_id'], 'LR', 0, 'L', $fill);
    $pdf->Cell(40, 6, $row['rental_date'], 'LR', 0, 'L', $fill);
    $pdf->Cell(40, 6, $row['start_date'], 'LR', 0, 'L', $fill);
    $pdf->Cell(40, 6, $row['end_date'], 'LR', 1, 'L', $fill);
    $fill = !$fill;
}

// Fetch the car names from the "cars" table
$query = 'SELECT brand, model, price FROM cars WHERE id = :car_id';
$stmt = $pdo->prepare($query);

// Loop through the renting history and replace car ID with car details
foreach ($rentingHistory as &$row) {
    $stmt->bindParam(':car_id', $row['car_id']);
    $stmt->execute();
    $carDetails = $stmt->fetch(PDO::FETCH_ASSOC);
    $row['car_id'] = $carDetails['brand'];
    $row['car_model'] = $carDetails['model'];
    $row['car_price'] = $carDetails['price'];
}

unset($row); // Unset the reference to the last element


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
    $html .= '<td>' . $row['command_id'] . '</td>';
    $html .= '<td>' . $row['car_id'] . '</td>';
    $html .= '<td>' . $row['car_model'] . '</td>';  

    $html .= '<td>' . $row['rental_date'] . '</td>';
    $html .= '<td>' . $row['start_date'] . '</td>';
    $html .= '<td>' . $row['end_date'] . '</td>';
    $html .= '<td>' . $row['car_price'] . '</td>';
    $html .= '</tr>';
}

$html .= '</table>';

// Output the HTML table
echo $html;


