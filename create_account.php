<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> DrJack</title>
    </head>

    <body>
        <h1>New account: </h1>
        <p>
            <form action="account_done.php" method="POST">
                First Name: <input type="text" name="fname" required><br>
                Last Name: <input type="text" name="lname" required><br>
                E-mail: <input type="email" name="email" required><br>
                Haslo:  <input type="password" name="password" required><br><br>
                <input type="submit" value="Create account">
                <input type="reset" value="Reset">
            </form>
        </p>

       
        
    </body>
</html>

