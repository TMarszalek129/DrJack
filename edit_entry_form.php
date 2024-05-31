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
    $value_1 = $_POST["value_1"];
    $value_2 = $_POST["value_2"];
    $timestamp = date("Y\-m\-d\Th:m:s", strtotime($_POST['timestamp']));
?>

<form action="edit_entry.php" method="POST">
    <label for="val_1">Value 1:</label>
    <input type="number" id="val_1" name="val_1" value = <?php echo $value_1 ?>>

    <label for="val_2">Value 2:</label>
    <input type="number" id="val_2" name="val_2" value=<?php echo $value_2 ?>>

    <label for="timestamp">Timestamp:</label>
    <input type="datetime-local" id="timestamp" name="timestamp" value = <?php echo $timestamp ?>>

    <input type="hidden" name="entry_id" value=<?php echo "$entry_id"; ?>>
    <input type="hidden" name="user_id" value=<?php echo "$user_id"; ?>>

    <input type="submit" value="OK">
</form>

<form action="exams.php" method="POST">
    <input type="hidden" name="email" value=<?php echo "$email"; ?> >
    <input type="hidden" name="password" value=<?php echo "$pass"; ?>>
    <input type="hidden" name="id" value=<?php echo "$user_id"; ?>>
    <input type="submit" value="BACK TO YOUR EXAMS!">
</form>
</body>
</html>