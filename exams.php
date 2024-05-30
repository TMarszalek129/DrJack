<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <title> DrJack</title>
        <link rel="icon" type="image/x-icon" href="images/favicon.ico">
        <style>
            
            table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            text-align: center;
            }

            td, th {
            border: 1px solid #ddd;
            padding: 8px;
            }

            tr:nth-child(even){background-color: #f2f2f2;}

            tr:hover {background-color: #ddd;}

            th {
            padding-top: 12px;
            padding-bottom: 12px;
            background-color: red;
            color: white;
            }
            
        </style>
    </head>

    <body>

        <?php
            session_start();
            $email = $_SESSION["email"];
            $pass = $_SESSION["pass"];
            $id = $_POST["id"];
            
            $weight = 0;
            $height = 0;

            $sql_name = "SELECT account_id, first_name, last_name, birth_date, sex FROM accounts WHERE account_id = ".$id;
            $sql_bmi = "SELECT account_id, measure_id, value_1, timestamp FROM measurements 
                        WHERE account_id = '$id' AND measure_id IN ('1', '2')";
            $sql_m = "SELECT * FROM measures
             INNER JOIN measurements ON measures.measure_id = measurements.measure_id 
             INNER JOIN units ON measures.unit_id = units.unit_id  
             WHERE measurements.account_id = ".$id;

            $servername = $_SESSION["servername"];
            $username = $_SESSION["username"];
            $password = $_SESSION["password"];
            $dbname = $_SESSION["dbname"];

            $conn = mysqli_connect($servername, $username, $password, $dbname);
            
            if(!$conn)
                die("Connection failed: ".mysqli_connect_error());

            $name = mysqli_query($conn, $sql_name);
            $ms = mysqli_query($conn, $sql_m);
            $w_h = mysqli_query($conn, $sql_bmi);
            
            if (mysqli_num_rows($name) > 0) {
            
                while($row = mysqli_fetch_assoc($name)) {
                    
                    $first_name = $row["first_name"];
                    $last_name = $row["last_name"];
                    $bday = $row["birth_date"];
                    $age = (date('Y') - date('Y',strtotime($bday)));
                    $sex = $row["sex"];
                }
                }
            if (mysqli_num_rows($w_h) > 0) {
        
                while($row = mysqli_fetch_assoc($w_h)) {
                    
                    
                    if($row['measure_id'] == 1)
                    {
                        if($weight == 0 || date("Y\-m\-d", strtotime($row['timestamp'])) > $timestamp)
                        {
                            $timestamp = $row['timestamp'];
                            $weight = $row['value_1'];
                        }
                    }
                    else
                    {
                        if($height == 0 || date("Y\-m\-d", strtotime($row['timestamp'])) > $timestamp)
                        {
                            $timestamp = $row['timestamp'];
                            $height = $row['value_1'];
                        }
                    }
                        
                    
                }
                }
            
            if($age <= 1)
            {
                $pulse_up = 205;
                $pulse_down = 105;
                $sys_pressure_up = 100; //systolic
                $sys_pressure_down = 90;
                $diast_pressure_up = 60; //diastolic
                $diast_pressure_down = 55;
            }
            else if($age < 11)
            {
                $pulse_up = 140;
                $pulse_down = 80;
                $sys_pressure_up = 110; 
                $sys_pressure_down = 100;
                $diast_pressure_up = 75; 
                $diast_pressure_down = 70;   
            }
            else if($age < 20)
            {
                $pulse_up = 100;
                $pulse_down = 60;
                $sys_pressure_up = 129; 
                $sys_pressure_down = 120;
                $diast_pressure_up = 84; 
                $diast_pressure_down = 80;  
            }
            else if($age < 60)
            {
                $pulse_up = 80;
                $pulse_down = 60;
                $sys_pressure_up = 129; 
                $sys_pressure_down = 120;
                $diast_pressure_up = 84; 
                $diast_pressure_down = 80;     
            }
            else
            {
                $pulse_up = 70;
                $pulse_down = 50;
                $sys_pressure_up = 139; 
                $sys_pressure_down = 130;
                $diast_pressure_up = 79; 
                $diast_pressure_down = 70;   
            }
            
            
            echo "<h1>Hello ".$first_name." ".$last_name."!</h1>";
            ?>
        <p>
            <form action="account.php" method="POST">
                <input type="hidden" name="email" value=<?php echo "$email"; ?> >
                <input type="hidden" name="password" value=<?php echo "$pass"; ?>>
                <input type="submit" value="BACK TO YOUR PROFILE!">
            </form>
        </p><hr>
        <?php

            echo "<h2>Your status: </h2>";
            echo "Your birthday: $bday <br>";
            $age = (date('Y') - date('Y',strtotime($bday)));
            echo "You have <b>$age</b> years <br>";
            $w_m = $sex == 'M' ? "man" : "woman";
            echo "You are a <b>$w_m</b> <br>";
            $bmi = round($weight / ( ($height/100) * ($height/100) ), 2);
            if($weight && $height)
                echo "Your BMI based on last height and weight measurements: <b>$bmi</b>";
            echo "<hr>";

            echo "<h2>Your examinations: </h2>";
            echo "<table>
                <tr>
                    <th>Measure</th>
                    <th>Value A</th>
                    <th>Value B</th>
                    <th>Unit</th>
                    <th>Timestamp</th>
                    <th>Standard</th>
                </tr>";
            if(mysqli_num_rows($ms) > 0) {
                while($row = mysqli_fetch_assoc($ms)) {

                    echo "<tr>";
                    echo"<td>".$row['measure_name']."</td>";
                    echo"<td>".$row['value_1']."</td>";
                    echo"<td>".$row['value_2']."</td>";
                    echo"<td>".$row['unit']."</td>";
                    echo"<td>".$row['timestamp']."</td>";
                    if($row['measure_name'] == "Pulse")
                        echo "<td>$pulse_down - $pulse_up</td>";
                    else if($row['measure_name'] == "Blood Presure")
                        echo "<td>$sys_pressure_down - $sys_pressure_up / $diast_pressure_down - $diast_pressure_up</td>";
                    else
                        echo "<td> </td>";
                    echo"</tr>";
                }
            }

            /*
            if(mysqli_query($conn, $sql_name)){
                echo "\nOK\n";
            }
            else
                echo "Blad: ".$sql."<br>".mysqli_error($conn);
            */ 
        ?>
       
    </body>
</html>