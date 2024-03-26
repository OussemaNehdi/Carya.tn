<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="http://localhost/Mini-PHP-Project/CSS/style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="HTML/login.html">Login</a></li>
        </ul>
    </nav>
    <div>
        <form method="post" action="login">
            <input type="email" name="email" placeholder="Email" required>
            <br>
            <input type="password" name="password" placeholder="Password" required>
            <br>
            <button type="submit">Login</button>
        </form>
    </div>
    <script src="./JS/script.js"></script>
</body>
</html>