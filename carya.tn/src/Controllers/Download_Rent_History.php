<?php 
// Include necessary files
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/Resources/TCPDF-main/tcpdf.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Command.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php';

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); // Method Not Allowed
    exit("Method Not Allowed");
}

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/Mini-PHP-Project/carya.tn/templates/login.php?message=You%20need%20to%20login%20first.&type=error");
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Get the renting history of the user
$rentingHistory = Command::getRentalCommandsByUserId($user_id);

if (!$rentingHistory) {
    header("Location: http://localhost/Mini-PHP-Project/carya.tn/index.php?message=No%20renting%20history%20found.&type=error");
    exit();
}

// Get the user details
$user=User::getUserById($user_id);   

// Check if the user exists
if (!$user) {
    header("Location: http://localhost/Mini-PHP-Project/carya.tn/index.php?message=User%20not%20found.&type=error");
    exit();
}

// Get the car details for each renting history
foreach ($rentingHistory as &$row) {
    // Get the car details by ID
    $carDetails = Car::getCarById($row->car_id);

    // Check if the car exists
    if (!$carDetails) {
        header("Location: http://localhost/Mini-PHP-Project/carya.tn/index.php?message=Car%20not%20found.&type=error");
        exit();
    }

    // Set the car details
    $row->car_id = $carDetails->brand;
    $row->car_model = $carDetails->model;
    $row->car_price = $carDetails->price;
}

// Unset the row variable
unset($row);

// Create a new PDF document
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