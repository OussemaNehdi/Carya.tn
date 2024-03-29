<?php
    // Include necessary files
    include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';

    // The $refferer variable holds the URL of the page that referred the user to the current page. 
    // It is used to redirect the user back to the page they came from after the operation is complete.
    $refferer = isset($_POST['refferer']) ? parse_url($_POST['refferer'], PHP_URL_PATH) : (isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) : 'http://localhost/Mini-PHP-Project/carya.tn/index.php');

    // Check if the request method is GET and 'id' parameter is set
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
        
        // Get the user ID from GET parameter
        $user_id = $_GET['id'];
        
        try {
            // Attempt to unban the user by ID
            $user_to_unban = User::getUserById($user_id);
            $user_to_unban->unbanUserById();
            
            // Redirect with a success message
            header("Location:$refferer?message=User%20unbanned%20successfully.");
            exit(); // Ensure script execution stops after redirect
        } catch (PDOException $e) {
            // Redirect with an error message if a PDO exception occurs
            header("$refferer?error=Error:%20" . urlencode($e->getMessage()));
            exit(); // Ensure script execution stops after redirect
        } catch (Exception $ex) {
            // Redirect with an error message if any other exception occurs
            header("Location: $refferer?error=Error:%20" . urlencode($ex->getMessage()));
            exit(); // Ensure script execution stops after redirect
        }
    } else {
        // Redirect with an error message if the request is invalid
        header("$refferer?error=Invalid%20request.");
        exit(); // Ensure script execution stops after redirect
    }
?>