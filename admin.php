<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <title> DrJack</title>
    </head>

    <body>

        <?php
            $servername = "mysql.agh.edu.pl";
            $username = "tmarsza1";
            $password = "SL80yoFJTkYbL5mf";
            $dbname = "tmarsza1";

            $conn = mysqli_connect($servername, $username, $password, $dbname);

            if(!$conn)
                die("Connection failed: ".mysqli_connect_error());

            $sql = "SELECT * FROM logins";

            $result = mysqli_query($conn, $sql);
        
            
            echo "<table>
                <tr>
                    <th>User ID</th>
                    <th>Timestamp</th>
                    <th>IP</th>
                    <th>Passed</th>
                </tr>";
            
        
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo"<td>".$row['user_id']."</td>";
                echo"<td>".$row['timestamp']."</td>";
                echo"<td>".$row['IP']."</td>";
                echo"<td>".$row['passed']."</td>";
                echo"</tr>";
                }
            echo "</table>";
            
        ?> 
        <br><a href="home.php"> Back to home </a>
    </body>
</html>