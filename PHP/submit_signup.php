<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    if (isset ($first_name, $last_name, $email, $password)) {
        $con = mysqli_connect('localhost', 'root', '', 'carrental');
        if ($con->connect_error) {
            die ("Failed to connect: " . $con->connect_error);
        } else {

            //checking if user already exists
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $email = trim($email);
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = mysqli_prepare($con, $sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                echo "User already exists";
                exit();
            }
            $stmt->close();

            //checking if password is at least 8 characters
            if (strlen($password) < 8) {
                echo "Password must have at least 8 characters";
                exit();
            } else {
                $password = trim($password);
            }

            //hashing the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);


            //inserting user into database
            $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssss", $first_name, $last_name, $email, $hashed_password);
                if (mysqli_stmt_execute($stmt)) {
                    echo "Registration successful";
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
        echo "All fields are required";
    }
} else {
    echo "Invalid request";
}
?>