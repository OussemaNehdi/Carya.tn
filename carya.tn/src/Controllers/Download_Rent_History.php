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
    $row->confirmed=  $row->confirmed==1 ? "Confirmed" : "Not Confirmed";
}

// Unset the row variable
unset($row);
$imageFile="../../Resources/Logo2.png";
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
// Create a new PDF document
$pdf->Image($imageFile, 20, 20, 30, 10, '', '', '', false, 150, '', false, false, 1, false, false, false);

// Set border style
$pdf->SetLineStyle(array('width' => 0.5, 'color' => array(0, 0, 0)));

// Add a border around the page
$pdf->Rect(5, 5, $pdf->getPageWidth() - 10, $pdf->getPageHeight() - 10);

// Set font
$pdf->SetFont('helvetica', '', 12);

// Rest of the code...

// Add a title
$pdf->SetFont('helvetica', 'B', 18);
$pdf->Cell(0, 20, 'Renting History', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'for: ' . $user->firstName . ' ' . $user->lastName, 0, 1, 'C');
$pdf->Cell(0, 10, 'Email: ' . $user->email, 0, 1, 'C');
$pdf->Ln(10);

// Add a table with the renting history data
$header = array('Rent ID', 'Brand', 'Rental Date', 'Start Date', 'End Date', 'Price');
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.3);
$pdf->SetFont('helvetica', 'B');


$pdf->Cell(20, 7, 'Rent ID', 1, 0, 'C', 1);
$pdf->Cell(40, 7, 'Brand', 1, 0, 'C', 1);
$pdf->Cell(25, 7, 'Rental Date', 1, 0, 'C', 1);
$pdf->Cell(25, 7, 'Start Date', 1, 0, 'C', 1);
$pdf->Cell(25, 7, 'End Date', 1, 0, 'C', 1);
$pdf->Cell(25, 7, 'Status', 1, 0, 'C', 1);
$pdf->Cell(25, 7, 'Price', 1, 0, 'C', 1);


$pdf->Ln();
$pdf->SetFont('helvetica', '');
$pdf->SetFillColor(224, 235, 255);
$pdf->SetTextColor(0);
$pdf->SetFont('');
$fill = false;
foreach ($rentingHistory as $row) {
    $pdf->Cell(20, 10, $row->command_id, 'LR', 0, 'C', $fill);
    $pdf->Cell(40, 10, $row->car_id . "-" . $row->car_model, 'LR', 0, 'C', $fill);
    $pdf->Cell(25, 10, $row->rental_date, 'LR', 0, 'C', $fill);
    $pdf->Cell(25, 10, $row->start_date, 'LR', 0, 'C', $fill);
    $pdf->Cell(25, 10, $row->end_date, 'LR', 0, 'C', $fill);
    $pdf->Cell(25, 10, $row->confirmed, 'LR', 0, 'C', $fill);
    $pdf->Cell(25, 10, $row->car_price, 'LR', 0, 'C', $fill);
    $pdf->Ln();
    $fill = !$fill;
}
   
$pdf->SetFont('helvetica', 'I', 10);
$pdf->Cell(0, 15, 'Thank you for trusting us', 0, 1, 'C');
$pdf->Cell(0, 15, '© Carya.tn', 0, 1, 'C');
$pdf->Output('renting_history.pdf', 'D');
?>