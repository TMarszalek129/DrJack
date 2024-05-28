<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <title> DrJack</title>
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
            $sql_name = "SELECT account_id, first_name, last_name FROM accounts WHERE account_id = ".$id;
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
            
            if (mysqli_num_rows($name) > 0) {
            
                while($row = mysqli_fetch_assoc($name)) {
                    
                    $first_name = $row["first_name"];
                    $last_name = $row["last_name"];
                }
                }
            echo "<h1>Hello ".$first_name." ".$last_name."!</h1>";
            echo "<h2>Your examination: </h2>";
            echo "<hr>";
            echo "<table>
                <tr>
                    <th>Measure</th>
                    <th>Value_1</th>
                    <th>Value_2</th>
                    <th>Unit</th>
                    <th>Timestamp</th>
                </tr>";
            if(mysqli_num_rows($ms) > 0) {
                while($row = mysqli_fetch_assoc($ms)) {

                    echo "<tr>";
                    echo"<td>".$row['measure_name']."</td>";
                    echo"<td>".$row['value_1']."</td>";
                    echo"<td>".$row['value_2']."</td>";
                    echo"<td>".$row['unit']."</td>";
                    echo"<td>".$row['timestamp']."</td>";
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
        <p>
            <form action="account.php" method="POST">
                <input type="hidden" name="email" value=<?php echo "$email"; ?> >
                <input type="hidden" name="password" value=<?php echo "$pass"; ?>>
                <input type="submit" value="BACK TO YOUR PROFILE!">
            </form>
        </p>
    </body>
</html>