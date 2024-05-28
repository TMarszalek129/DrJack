<?php
    session_start();
    if(!isset($_SESSION["startLogin"]) || $_SESSION["startLogin"] != 1)
    {
        session_regenerate_id();
        $_SESSION = array();
        $_SESSION["startLogin"] = 1;
        
    }

    $servername = "mysql.agh.edu.pl";
    $username = "";
    $password = "";
    $dbname = "";
    $_SESSION["servername"] = $servername;
    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password;
    $_SESSION["dbname"] = $dbname;
    
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <title> DrJack</title>
    </head>

    <body style="text-align: center;">
        <h1>Logowanie: </h1>
        <hr>
        <img src="images/dr_jack.jpg" alt="DrJack" width="104" height="142">
        <hr>
        <p>
            <form action="account.php" method="POST">
                E-mail: <input type="email" name="email" required><br>
                Haslo:  <input type="password" name="password" required><br><br>
                <input type="submit" value="GET!">
                <input type="reset" value="DROP!">
            </form>
        </p>
        
        <a href="create_account.php"> Create new account </a><br>
        <a href="change_password.php"> Do you forgot password? </a><br>
        <a href="admin.php">Admin site</a>

    </body>
</html>