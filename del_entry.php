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
    $email = $_SESSION["email"];
    $pass = $_SESSION["pass"];
    function format($dane)
    {
        $dane = trim($dane);
        $dane = stripslashes($dane);
        $dane = htmlspecialchars($dane);
        return $dane;
    }

    $entry_id = $_POST["entry_id"];
    $user_id = $_POST["user_id"];
    $sql_del = "DELETE FROM measurements WHERE measurement_id = $entry_id";

    $servername = $_SESSION["servername"];
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $dbname = $_SESSION["dbname"];

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if(!$conn)
        die("Connection failed: ".mysqli_connect_error());

    if(mysqli_query($conn, $sql_del))
    {
        echo "Measurement was deleted";
    }
    else
    {
        echo "Error: <br>";
        echo "Something was wrong, please try again!";
    }

?>
<form action="account.php" method="POST">
    <input type="hidden" name="email" value=<?php echo "$email"; ?> >
    <input type="hidden" name="password" value=<?php echo "$pass"; ?>>
    <input type="hidden" name="id" value=<?php echo "$user_id"; ?>>
    <input type="submit" value="BACK TO YOUR EXAMS!">
</form>
</body>
</html>