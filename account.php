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
               
            }

           

            $sqlSelect = "SELECT * FROM accounts";
           
            $sql_measures = "SELECT * FROM measures";
            $sql_units = "SELECT * FROM units";
           

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
            $my_measures = array();
            $my_units = array();


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

                    if($row["account_id"] == $user_id)
                    {
                        $my_measures[] = $el;
                    }
                }
                }
            if (mysqli_num_rows($units) > 0) {
        
                while($row = mysqli_fetch_assoc($units)) {
                    $id = $row["unit_id"];
                    $el = $row["unit"];
                    $units_array["$id"] = $el;

                    if($row["account_id"] == $user_id)
                    {
                        $my_units[] = $el;
                    }
                }
                }
            if(isset($user_id)){
                $sql = "INSERT INTO logins(account_id, passed, IP)
                VALUES ('".$user_id."', '".$passed."', '".$ip."')";
            }
            else
            {
                $sql = "INSERT INTO logins(passed, IP)
                VALUES ('".$passed."', '".$ip."')";
            }

            if($passed == 1){
                echo "Hello $first_name $last_name! <br>";
                echo "Your birthday: $bday <br>";
                $age = (date('Y') - date('Y',strtotime($bday)));
                echo "You have <b>$age</b> years <br>";
                $w_m = $sex == 'M' ? "man" : "woman";
                echo "You are a <b>$w_m</b>";
                if(!(empty($to_base)))
                    mysqli_query($conn, $sql);

                echo "
                
                <br>
                <p>
                    <form action='exams.php' method='POST'>
                        <input type='hidden' id='id' name='id' value=$user_id>
                        <input type='submit' value='See your examinations'>
                    </form>
                </p>
                <hr>
                <h2>Add new measurement: </h2>
                <p>
                <form action='success.php'  method='POST'>
                    <label for='measures'>Measure: </label>
                    <input list='measure' id='measures' name='measure'>
                    <datalist id='measure'>";
                    foreach($measures_array as $m) 
                        echo"<option value='$m'>\n";

                    echo"</datalist>
    
                    <label for='units'>Unit: </label>
                    <input list='unit' id='units' name='unit'>
                    <datalist id='unit'>";
                    foreach($units_array as $u) 
                        echo"<option value='$u'>\n";
                
                    echo"</datalist>
    
                    <label for='val_1'>Value 1:</label>
                    <input type='number' id='val_1' name='val_1'>
    
                    <label for='val_2'>Value 2:</label>
                    <input type='number' id='val_2' name='val_2' value='0'>
    
                    <label for='timestamp'>Timestamp:</label>
                    <input type='datetime-local' id='timestamp' name='timestamp'>
    
                    <input type='hidden' id='id' name='id' value=$user_id>
    
                    <input type='submit' value='Add new measurement'>
                </form>
                </p><hr>
    
                <h2>Add new examination type with new unit: </h2>
                <p>
                <form action='success_measure_unit.php'  method='POST'>
    
                    <label for='measure'>Measure:</label>
                    <input type='text' id='measure' name='measure'>
                    <label for='unit'>Unit:</label>
                    <input type='text' id='unit' name='unit'>
    
                    <input type='hidden' id='id' name='id' value=$user_id>
    
                    <input type='submit' value='Add new examination type'>
                </form>
                </p><hr>
    
                <h2>Add new examination type with existing unit: </h2>
                <p>
                <form action='success_measure.php'  method='POST'>
    
                    <label for='measure'>Measure:</label>
                    <input type='text' id='measure' name='measure'>
    
                    <label for='units'>Unit: </label>
                    <input list='unit' id='units' name='unit'>
                    <datalist id='unit'>";
                    foreach($units_array as $u) 
                        echo"<option value='$u'>\n";
                    
                    echo"</datalist>
    
                    <input type='hidden' id='id' name='id' value=$user_id>
    
                    <input type='submit' value='Add new examination type'>
                </form>
                </p><hr>
    
                <h2>Add only new unit: </h2>
                <p>
                <form action='success_unit.php'  method='POST'>
    
                    <label for='unit'>Unit:</label>
                    <input type='text' id='unit' name='unit'>
    
                    <input type='hidden' id='id' name='id' value=$user_id>
    
                    <input type='submit' value='Add new unit type'>
                </form>
                </p><hr>

                <h2>Edit your added examination: </h2>";

                echo"<p>
                    <form action='edit_measure.php'  method='POST'>
                    <label for='my_measures'>Measure: </label>
                    <input list='my_measure' id='my_measures' name='my_measure'>
                    <datalist id='my_measure'>";
                    foreach($my_measures as $m) 
                        echo"<option value='$m'>\n";
                    echo"</datalist>
                    <label for='new_measure'>New measure: </label>
                    <input type='text' id='new_measure' name='new_measure'>

                    <input type='hidden' id='id' name='id' value=$user_id>
    
                    <input type='submit' value='Edit your measure'>
                    </form>
                    </p><hr>
                    ";
                echo "<h2>Edit your added unit: </h2>";                    
                echo"<p>
                    <form action='edit_unit.php'  method='POST'>
                    <label for='my_units'>Measure: </label>
                    <input list='my_unit' id='my_units' name='my_unit'>
                    <datalist id='my_unit'>";
                    foreach($my_units as $u) 
                        echo"<option value='$u'>\n";
                    echo"</datalist>
                    <label for='new_unit'>New unit: </label>
                    <input type='text' id='new_unit' name='new_unit'>

                    <input type='hidden' id='id' name='id' value=$user_id>
    
                    <input type='submit' value='Edit your unit'>
                    </form>
                    </p><hr>
                    ";
                

                echo "<p>
                    <form id='home' action='log_out.php' method='POST'>
                        <input type='submit' value='Log out'>
                    </form>
                    </p>";
                
                echo "<br><a href='change_password.php' > Reset password </a>";
            }
            else{
                mysqli_query($conn, $sql);
                echo "\nWrong email or password!!!\n";
                echo "<br><a href='home.php' style='position: absolute; bottom: 0px'>Back to home</a>";
                
            }
           
               
            ?>
            
    </body>
</html>