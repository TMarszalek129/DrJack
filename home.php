<?php
    session_start();
    if(!isset($_SESSION["startLogin"]) || $_SESSION["startLogin"] != 1)
    {
        session_regenerate_id();
        $_SESSION = array();
        $_SESSION["startLogin"] = 1;
        $_SESSION["komunikat"] = "U mnie dziala";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> DrJack</title>
    </head>

    <body>
        <h1>Logowanie: </h1>
        <p>
            <form action="account.php" method="POST">
                E-mail: <input type="email" name="email" required><br>
                Haslo:  <input type="password" name="password" required><br><br>
                <input type="submit" value="GET!">
                <input type="reset" value="DROP!">
            </form>
        </p>
        
        <a href="create_account.php"> Create new account </a><br>
        <a href="change_password.php"> Change your actual password </a>

    </body>
</html>