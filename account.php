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
        function format($dane)
            {
                $dane = trim($dane);
                $dane = stripslashes($dane);
                $dane = htmlspecialchars($dane);
                return $dane;
            }
            $to_base = $_POST["to_base"];
            $passed = 0;
            $new_measurement = 0;
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                if(empty($_POST["email"])){
                    $emailErr = "You must enter your e-mail";
                }
                else
                    $email = format($_POST["email"]);
                    $_SESSION["email"] = $email;

                if(empty($_POST["password"])){
                    $passErr = "You must enter your password"; 
                }
                else{
                    $pass = format($_POST["password"]);
                    $_SESSION["pass"] = $pass;
                    $hash_pass = password_hash($pass, PASSWORD_DEFAULT);
                }

                $measure = format($_POST["measure"]);
                $unit = format($_POST["unit"]);
                $value_1 = format($_POST["value_1"]);
                $value_2 = format($_POST["value_2"]);
                $timestamp = format($_POST["timestamp"]);

                if($value_2 == 0){
                    $value_2 = NULL;
                }

                if(!(empty($_POST["measure"]))){
                    $measure_id = array_search("$measure", $measures_array);
                }

                if(!(empty($_POST["unit"]))){
                    $unit_id = array_search("$unit", $units_array);
                }

                if(!(empty($_POST["measure"])) && !(empty($_POST["unit"])) && !(empty($_POST["value_1"])) 
                    && !(empty($_POST["value_2"])) && !(empty($_POST["timestamp"]))){
                        $new_measurement = 1;
                    }
               
            }

           

            $sqlSelect = "SELECT * FROM accounts";
           
            $sql_measures = "SELECT * FROM measures";
            $sql_units = "SELECT * FROM units";
            $sql_insert_measurement = "INSERT INTO measurement(account_id, measure_id, value_1, value_2, timestamp)
                                        VALUES ('".$user_id."', '".$measure_id."', '".$value_1."', '".$value_2."', '".$timestamp."')";

            $servername = $_SESSION["servername"];
            $username = $_SESSION["username"];
            $password = $_SESSION["password"];
            $dbname = $_SESSION["dbname"];

            


            if($_SERVER['HTTP_CLIENT_IP'])
            {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
            else if($_SERVER['HTTP_X_FORWARDED_FOR'])
            {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else
            {
                $ip = $_SERVER['REMOTE_ADDR'];
            }

            $conn = mysqli_connect($servername, $username, $password, $dbname);
            
            if(!$conn)
                die("Connection failed: ".mysqli_connect_error());

            $result = mysqli_query($conn, $sqlSelect);
            $measures = mysqli_query($conn, $sql_measures);
            $units = mysqli_query($conn, $sql_units);
            $measures_array = array();
            $units_array = array();


           if (mysqli_num_rows($result) > 0) {
            
                while($row = mysqli_fetch_assoc($result)) {
                    if($row["email"] == $email && password_verify($pass, $row["password"])) {
                        $passed = 1;
                        $user_id = $row['account_id'];
                        $first_name = $row['first_name']; 
                        $last_name = $row['last_name'];
                        $bday = $row['birth_date'];
                        $sex = $row['sex'];    
                    }
                }
                }   
            if (mysqli_num_rows($measures) > 0) {
            
                while($row = mysqli_fetch_assoc($measures)) {
                    $id = $row["measure_id"];
                    $el = $row["measure_name"];
                    $measures_array["$id"] = $el;
                }
                }
            if (mysqli_num_rows($units) > 0) {
        
                while($row = mysqli_fetch_assoc($units)) {
                    $id = $row["unit_id"];
                    $el = $row["unit"];
                    $units_array["$id"] = $el;
                }
                }
            
            $sql = "INSERT INTO logins(account_id, passed, IP)
            VALUES ('".$user_id."', '".$passed."', '".$ip."')";
            

            if($passed == 1){
                echo "Hello $first_name $last_name! <br>";
                echo "Your birthday: $bday <br>";
                $age = (date('Y') - date('Y',strtotime($bday)));
                echo "You have <b>$age</b> years <br>";
                $w_m = $sex == 'M' ? "man" : "woman";
                echo "You are a <b>$w_m</b>";
                if(!(empty($to_base)))
                    mysqli_query($conn, $sql);
            }
            else
                echo "\nWrong email or password!!!\n";
            if($new_measurement == 1){
                mysqli_query($conn, $sql_insert_measurement);
                $new_measurement = 0;
                
            }
                ?>
            <br>
            <p>
                <form action="exams.php" method="POST">
                    <input type="hidden" id="id" name="id" value=<?php echo "$user_id"; ?>>
                    <input type="submit" value="See your examinations">
                </form>
            </p>
            <hr>
            <h2>Add new measurement: </h2>
            <p>
            <form action="success.php"  method="POST">
                <label for="measures">Measure: </label>
                <input list="measure" id="measures" name="measure">
                <datalist id="measure">
                <?php foreach($measures_array as $m) 
                    echo"<option value='$m'>\n";
                    ?>
                </datalist>

                <label for="units">Unit: </label>
                <input list="unit" id="units" name="unit">
                <datalist id="unit">
                <?php foreach($units_array as $u) 
                    echo"<option value='$u'>\n";
                    ?>
                </datalist>

                <label for="val_1">Value 1:</label>
                <input type="number" id="val_1" name="val_1">

                <label for="val_2">Value 2:</label>
                <input type="number" id="val_2" name="val_2" value="0">

                <label for="timestamp">Timestamp:</label>
                <input type="datetime-local" id="timestamp" name="timestamp">

                <input type="hidden" id="id" name="id" value=<?php echo "$user_id"; ?>>

                <input type="submit" value="Add new measurement">
            </form>
            </p><hr>

            <h2>Add new examination type with new unit: </h2>
            <p>
            <form action="success_measure_unit.php"  method="POST">

                <label for="measure">Measure:</label>
                <input type="text" id="measure" name="measure">
                <label for="unit">Unit:</label>
                <input type="text" id="unit" name="unit">

                <input type="hidden" id="id" name="id" value=<?php echo "$user_id"; ?>>

                <input type="submit" value="Add new examination type">
            </form>
            </p><hr>

            <h2>Add new examination type with existing unit: </h2>
            <p>
            <form action="success_measure.php"  method="POST">

                <label for="measure">Measure:</label>
                <input type="text" id="measure" name="measure">

                <label for="units">Unit: </label>
                <input list="unit" id="units" name="unit">
                <datalist id="unit">
                <?php foreach($units_array as $u) 
                    echo"<option value='$u'>\n";
                    ?>
                </datalist>

                <input type="hidden" id="id" name="id" value=<?php echo "$user_id"; ?>>

                <input type="submit" value="Add new examination type">
            </form>
            </p><hr>

            <h2>Add only new unit: </h2>
            <p>
            <form action="success_unit.php"  method="POST">

                <label for="unit">Unit:</label>
                <input type="text" id="unit" name="unit">

                <input type="hidden" id="id" name="id" value=<?php echo "$user_id"; ?>>

                <input type="submit" value="Add new unit type">
            </form>
            </p><hr>

            <p>
                <form action="log_out.php" method="POST">
                    <input type="submit" value="Log out">
                </form>
            </p>

            <br><a href="change_password.php" style="position: absolute; bottom: 0px"> Reset password </a>   
        
        
    </body>
</html>