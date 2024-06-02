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
        
        $user_id = $_POST["id"];
        
        $sql_units = "SELECT * FROM units WHERE account_id = '$user_id'";

        $servername = $_SESSION["servername"];
        $username = $_SESSION["username"];
        $password = $_SESSION["password"];
        $dbname = $_SESSION["dbname"];

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        $my_units = mysqli_query($conn, $sql_units);
        $my_units_array = array();

        if (mysqli_num_rows($my_units) > 0) {
        
            while($row = mysqli_fetch_assoc($my_units)) {
                $id = $row["unit_id"];
                $el = $row["unit"];
                $my_units_array["$id"] = $el;
            }
            }
            
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
    
            $unit = format($_POST["my_unit"]);
            $new_unit = format($_POST["new_unit"]);

            if(!(empty($_POST["my_unit"]))){
                $unit_id = array_search("$unit", $my_units_array);
            }

            if(isset($unit_id))
                $edit_unit = 1;
            else
                $edit_unit = 0;
            
            
            $sql_edit_unit = "UPDATE units
                                 SET unit = '$new_unit'
                                 WHERE unit_id = '$unit_id'";
            if($edit_unit == 1){
                if(mysqli_query($conn, $sql_edit_unit)){
                    echo "\nYour unit was edited\n";
                }
            }
            else {
                    echo "Error: Something is wrong, please try again";
                    
            }                 
            }

        ?>

        <p>
            <form action="account.php" method="POST">
                <input type="hidden" name="email" value=<?php echo "$email"; ?> ><br>
                <input type="hidden" name="password" value=<?php echo "$pass"; ?>><br><br>
                <input type="submit" value="BACK TO YOUR PROFILE!">
            </form>
        </p>
    </body>
</html>