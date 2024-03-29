<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /Mini-PHP-Project/carya.tn/index.php?error=invalid_method');
    exit;
}

if (!isset($_POST['km_min']) || !isset($_POST['km_max']) || 
    !isset($_POST['price_min']) || !isset($_POST['price_max'])) {
    header('Location: /Mini-PHP-Project/carya.tn/index.php?error=missing_data');
    exit;
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
if (!empty($_POST['km_min']) && !empty($_POST['km_max'])) {
    $filters['km_min'] = $_POST['km_min'];
    $filters['km_max'] = $_POST['km_max'];
}

// Check if price range filter is set
if (!empty($_POST['price_min']) && !empty($_POST['price_max'])) {
    $filters['price_min'] = $_POST['price_min'];
    $filters['price_max'] = $_POST['price_max'];
}

// Construct the query string
$queryString = http_build_query($filters);

$referer = isset($_POST['referer']) ? $_POST['referer'] : (isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH)  : '/Mini-PHP-Project/carya.tn/index.php');

// Redirect with the constructed query string
header("Location: $referer?$queryString");
exit;
?>
