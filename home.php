<?php
    session_start();
    if(!isset($_SESSION["startLogin"]) || $_SESSION["startLogin"] != 1)
    {
        session_regenerate_id();
        $_SESSION = array();
        $_SESSION["startLogin"] = 1;
        
    }

    $servername = "";
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
        <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    </head>

    <body style="text-align: center;">
        <h1 style="background-color:DodgerBlue;">Log site: </h1>
        <hr>
        <blockquote cite="https://www.filmweb.pl/film/Doctor+Jack-1922-181424" >
            <img src="images/dr_jack.jpg" alt="DrJack" width="150" height="200">
        </blockquote>
        <hr>
        <p>
            <form action="account.php" method="POST">
                E-mail: <input type="email" name="email" required><br>
                Haslo:  <input type="password" name="password" required><br><br>
                <input type="hidden" name="to_base" value="1">
                <input type="submit" value="GET!">
                <input type="reset" value="DROP!">
            </form>
        </p>
        
        <a href="create_account.php"> Create new account </a><br>
        <a href="change_password.php"> Do you forgot password? </a><br>
        <a href="admin.php" style="color:red;">Admin site</a><br>
        

    </body>
</html>