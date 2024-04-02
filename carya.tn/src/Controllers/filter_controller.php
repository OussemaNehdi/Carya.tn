<?php
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    exit("Method Not Allowed");
}

// Check if the necessary POST parameters are set
if (!isset($_POST['km_min']) || !isset($_POST['km_max']) || 
    !isset($_POST['price_min']) || !isset($_POST['price_max'])) {
    header('Location: /Mini-PHP-Project/carya.tn/index.php?message=missing_data&type=error');
    exit();
}

// Initialize an empty array to store the filter parameters
$filters = [];

// Check if brand filter is set
if (!empty($_POST['brand'])) {
    $filters['brand'] = implode(',', $_POST['brand']);
}

// Check if model filter is set
if (!empty($_POST['model'])) {
    $filters['model'] = implode(',', $_POST['model']);
}

// Check if color filter is set
if (!empty($_POST['color'])) {
    $filters['color'] = implode(',', $_POST['color']);
}

// Check if kilometers range filter is set
if (!empty($_POST['km_min']) || !empty($_POST['km_max'])) {
    $filters['km_min'] = $_POST['km_min'];
    $filters['km_max'] = $_POST['km_max'];
}

// Check if price range filter is set
if (!empty($_POST['price_min']) || !empty($_POST['price_max'])) {
    $filters['price_min'] = $_POST['price_min'];
    $filters['price_max'] = $_POST['price_max'];
}

// Construct the query string
$queryString = http_build_query($filters);

// The referer will be the page that the user will be sent to once the code is executed
$referer = isset($_POST['referer']) ? $_POST['referer'] : (isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH)  : '/Mini-PHP-Project/carya.tn/index.php');

// Redirect with the constructed query string
header("Location: $referer?$queryString");
exit;
?>
