<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <title> DrJack</title>
        <link rel="icon" type="image/x-icon" href="images/favicon.ico">
        <style>
            
        </style>
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
        $user_id = format($_POST["id"]);
        $passed = 0;
        $new_unit = 0;
        $self_units = 0;

        $sql_measures = "SELECT * FROM measures";
        $sql_units = "SELECT * FROM units";

        $servername = $_SESSION["servername"];
        $username = $_SESSION["username"];
        $password = $_SESSION["password"];
        $dbname = $_SESSION["dbname"];

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        $measures = mysqli_query($conn, $sql_measures);
        $units = mysqli_query($conn, $sql_units);
        $measures_array = array();
        $units_array = array();
        $measures_units_array = array();

        if (mysqli_num_rows($measures) > 0) {
        
            while($row = mysqli_fetch_assoc($measures)) {
                $id = $row["measure_id"];
                $unit_id = $row["unit_id"];
                $el = $row["measure_name"];
                $measures_array["$id"] = $el;
                $measures_units_array["$el"] = $unit_id;
                
                $acc = $row["account_id"];
                if($acc == $user_id)
                    $self_measures++;
            }
            }
        if (mysqli_num_rows($units) > 0) {
    
            while($row = mysqli_fetch_assoc($units)) {
                $id = $row["unit_id"];
                $el = $row["unit"];
                $units_array["$id"] = $el;

                $acc = $row["account_id"];
                if($acc == $user_id)
                    $self_units++;
            }
            }
        
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
        
                $unit = format($_POST["unit"]);

                if(!(empty($_POST["unit"]))){
                    $unit_id = array_search("$unit", $units_array);
                }
    
    
                if(empty($unit_id)){
                    $new_unit = 1;
                }
                else
                    $new_unit = 0;
                
                $sql_insert_unit= "INSERT INTO units(unit, account_id)
                                    VALUES ('".$unit."', '".$user_id."')";
                if($new_unit == 1 && $self_units < 5){
                    if(mysqli_query($conn, $sql_insert_unit)){
                        echo "\nNew unit successfully added\n";

                    }
                }
                else {
                        echo "Error: ";
                        if(!(empty($unit_id)))
                            echo "\nYour unit has already existed, change name or use existed one\n";
                        if($self_units >= 5)
                            echo "\nYou added 5 or more units, you do not have permission to add more, please delete exists\n";
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