<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <title> DrJack</title>
    </head>

    <body>
        <h1>Actual data: </h1>
        <p>
            <form action="changer.php" method="POST">
                E-mail: <input type="email" name="email" required><br>
                Actual password:  <input type="password" name="apassword" required><br>
                New password:  <input type="password" name="npassword" required><br><br>
                <input type="submit" value="Change password">
                <input type="reset" value="Reset">
            </form>
        </p>

       
        <br><a href="home.php"> Back to home </a>
    </body>
</html>
