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
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
        Username:<br>
        <input type="text" name="username"><br>
        Password:<br>
        <input type="password" name="password"><br>
        <input type="submit" name="signup" value="Sign Up">
        <input type="submit" name="login" value="Log In">
    </form>
</body>
</html>
    

<?php
    session_start();
    
    include("database.php");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = $_POST["password"];
        
        if(empty($username)){
                echo "You haven't enter username";
        }
        elseif (empty($password)){
            echo "You haven't enter password";
        }
        elseif (!preg_match("/^[a-zA-Z0-9_]+$/", $username)){
            echo "Username can't have special characters";
        }
        else{
            if(isset($_POST["signup"])){
                $hash = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (user, password)
                        VALUES ('$username', '$hash')";

                try{
                    mysqli_query($conn, $sql);
                    echo "You have registered";
                }
                catch(mysqli_sql_exception){
                    echo "Username already exists.";
                }
            } 
            elseif(isset($_POST["login"])){
                $sql_verify = "SELECT id, user, password, reg_date FROM users WHERE user='$username'";
                $result = mysqli_query($conn, $sql_verify);
                
                if (mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        if (password_verify($password, $row["password"])){
                            $_SESSION["username"] = $username;
                            header("Location: dashboard.php");
                            exit();
                        }
                        else{
                            echo "Incorrect password";
                        }
                    }
                }
                else{
                    echo "User not found";
                }
            }  
        }
    }
    mysqli_close($conn);
?>

<?php
    include("footer.html");
?>