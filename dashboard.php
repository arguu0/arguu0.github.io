<?php
    include("header.html");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    THIS IS YOUR PROFILE PAGE<br>
</body>
</html>

<?php
    session_start();
    $username = $_SESSION["username"];
    echo "user: " . $username . "<br>";
?>