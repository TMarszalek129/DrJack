<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <title> DrJack</title>
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
            $new_measurement = 0;

            $sql_measures = "SELECT * FROM measures WHERE account_id = 0 OR account_id = '$user_id'";
            $sql_units = "SELECT * FROM units WHERE account_id = 0 OR account_id = '$user_id'";

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
                }
                }
            if (mysqli_num_rows($units) > 0) {
        
                while($row = mysqli_fetch_assoc($units)) {
                    $id = $row["unit_id"];
                    $el = $row["unit"];
                    $units_array["$id"] = $el;
                }
                }

            if($_SERVER["REQUEST_METHOD"] == "POST")
            {

                
                $measure = format($_POST["measure"]);
                $unit = format($_POST["unit"]);
                $value_1 = format($_POST["val_1"]);
                $value_2 = (int)format($_POST["val_2"]);
                $timestamp = format($_POST["timestamp"]);
                $timestamp = str_replace("T", " ", $timestamp);

                

                if($value_2 == 0){
                    $value_2 = NULL;
                }

                if(!(empty($_POST["measure"]))){
                    $measure_id = array_search("$measure", $measures_array);
                }

                if(!(empty($_POST["unit"]))){
                    $unit_id = array_search("$unit", $units_array);
                }

                if($unit_id == $measures_units_array["$measure"]){
                    $new_measurement = 1;
                }
                else
                    $new_measurement = 0;

                
               
            }

            if($value_2)
                $sql_insert_measurement = "INSERT INTO measurements(account_id, measure_id, value_1, value_2, timestamp)
                                        VALUES ('".$user_id."', '".$measure_id."', '".$value_1."', '".$value_2."', '".$timestamp."')";
            else
                $sql_insert_measurement = "INSERT INTO measurements(account_id, measure_id, value_1, timestamp)
                                        VALUES ('".$user_id."', '".$measure_id."', '".$value_1."', '".$timestamp."')";

            

            if($new_measurement == 1){
                if(mysqli_query($conn, $sql_insert_measurement)){
                    echo "\nNew measurement successfully added\n";
                }
            }
            else {
                    echo "Blad: ".$sql."<br>".mysqli_error($conn);
                    echo "\nMeasure and unit does not compatible\n";
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
