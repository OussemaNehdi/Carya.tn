<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];



    if (isset($first_name, $last_name, $email, $password)) {
        $con = mysqli_connect('localhost', 'root', '', 'carrental');
        if ($con->connect_error) {
            die("Failed to connect: " . $con->connect_error);
        } else {


            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $email = trim($email);
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

            if (strlen($password) < 8) {
                header('Location: http://localhost/Mini-PHP-Project/HTML/login.php?message=Password must be at least 8 characters&slide=register');
                exit();
            } else {
                $password = trim($password);
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);


            if (isset($_POST['check1'])) {
                $customer = $_POST['check1'];
                $role = $customer;
            } 

            if (isset($_POST['check2'])) {
                $seller = $_POST['check2'];
                $role = $seller;
            } 



            $sql = "INSERT INTO users (firstName, lastName, email, password, role) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sssss", $first_name, $last_name, $email, $password, $role);
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
        }
    } else {
        header('Location: http://localhost/Mini-PHP-Project/HTML/login.php?message=All fields are required&slide=register');
    }
} else {
    echo "Invalid request";
}
?>