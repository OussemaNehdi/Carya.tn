<?php

session_start();

//make connection
$con = mysqli_connect('localhost', 'root', '', 'carrental');
if ($con->connect_error) {
    die ("Failed to connect : " . $con->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset ($_POST['email']) && isset ($_POST['password'])) {

        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        //checking if user already exists
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($con, $sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            //if (password_verify($password, $data['password'])) {     (we can use this method too)
            if ($data['password'] === $password) {
                if ($data['role'] === 'banned') {
                    header('Location: http://localhost/Mini-PHP-Project/HTML/login.php?message=You are banned&slide=login');
                    exit();
                }
                
                $_SESSION['user'] = $data['firstName'];
                $_SESSION['user_id'] = $data['id'];
                $_SESSION['role'] = $data['role'];

                header('Location: http://localhost/Mini-PHP-Project/');
                exit();
            } else {
                header('Location: http://localhost/Mini-PHP-Project/HTML/login.php?message=Incorrect password&slide=login');
            }
        } else {
            echo "User not found";
            header('Location: http://localhost/Mini-PHP-Project/HTML/login.php?message=User not found&slide=login');
        }
        $stmt->close();
    } else {
        echo "Email or password not provided";
    }
    $stmt->close();
} else {
    echo "Invalid request";
}

mysqli_close($con);

?>