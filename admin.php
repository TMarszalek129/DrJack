<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> DrJack</title>
    </head>

    <body>

        <?php
            $servername = "mysql.agh.edu.pl";
            $username = "";
            $password = "";
            $dbname = "";

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