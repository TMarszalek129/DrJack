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
<?php
    session_start();
    session_unset();
    session_destroy();

    echo "You successfully logged out!";
?>
<br><a href="home.php" style="position: absolute; bottom: 0px">>>>Back to home</a>
</body>
</html>