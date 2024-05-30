<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <title> DrJack</title>
        <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    </head>

    <body>
        <h1>New account: </h1>
        <p>
            <form action="account_done.php" method="POST">
                First Name: <input type="text" name="fname" required><br>
                Last Name: <input type="text" name="lname" required><br>
                Birthdate: <input type="date" name="bdate" required><br>
                Sex: <input list="sex" name="sex">
                        <datalist id="sex">
                            <option value="M">
                            <option value="F">
                        </datalist><br>
                E-mail: <input type="email" name="email" required><br>
                Haslo:  <input type="password" name="password" required><br><br>
                <input type="submit" value="Create account">
                <input type="reset" value="Reset">
            </form>
        </p>

       
        
    </body>
</html>

