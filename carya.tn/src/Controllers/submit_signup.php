<?php
// ckeck if the session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// include the database connection
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // get the form data
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $customer = $_POST['check1'];

    $role = $customer;

    if (isset($first_name, $last_name, $email, $password)) {

        // sanitize the email
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $email = trim($email);

        // check if the email exists
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($con, $sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            header('Location: http://localhost/Mini-PHP-Project/HTML/login.php?message=User already exists&slide=register');
            exit();
        }
        $stmt->close();

        // validate the password
        if (strlen($password) < 8) {
            header('Location: http://localhost/Mini-PHP-Project/HTML/login.php?message=Password must be at least 8 characters&slide=register');
            exit();
        } else {
            $password = trim($password);
        }

        // hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);


        // insert the user into the database
        $sql = "INSERT INTO users (firstName, lastName, email, password, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssss", $first_name, $last_name, $email, $hashed_password, $role);
            if (mysqli_stmt_execute($stmt)) {
                header('Location: http://localhost/Mini-PHP-Project/HTML/login.php?message=Account created successfully');
            } else {
                echo "Error: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error in preparing SQL statement: " . mysqli_error($con);
        }

        mysqli_close($con);

    } else {
        header('Location: http://localhost/Mini-PHP-Project/HTML/login.php?message=All fields are required&slide=register');
    }
} else {
    echo "Invalid request";
}
?>