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
        <a href="admin.php">Admin</a>

    </body>
</html>