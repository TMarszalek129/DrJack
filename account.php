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
        function format($dane)
            {
                $dane = trim($dane);
                $dane = stripslashes($dane);
                $dane = htmlspecialchars($dane);
                return $dane;
            }

            $passed = 0;
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                if(empty($_POST["email"])){
                    $emailErr = "You must enter your e-mail";
                    
                }
                else
                    $email = format($_POST["email"]);

                if(empty($_POST["password"])){
                    $passErr = "You must enter your password";
                    
                }
                else{
                    $pass = format($_POST["password"]);
                    $hash_pass = password_hash($pass, PASSWORD_DEFAULT);
                }
            }

            $sqlSelect = "SELECT * FROM accounts";

            $servername = "mysql.agh.edu.pl";
            $username = "";
            $password = "";
            $dbname = "";
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

            if (mysqli_num_rows($result) > 0) {
                
                while($row = mysqli_fetch_assoc($result)) {
                    if($row["email"] == $email && password_verify($pass, $row["password"])) {
                        $passed = 1;
                        $user_id = $row['account_id'];    
                    }
                }
                } 
            
            $sql = "INSERT INTO logins(user_id, passed, IP)
                    VALUES ('".$user_id."', '".$passed."', '".$ip."')";

            if($passed == 1){
                echo "You are logged in\n";
                print_r($_SESSION);
                mysqli_query($conn, $sql);
                $_SESSION["ID"] = $user_id;                
            }
            else
                echo "\nWrong email or password!!!\n";
                ?>
                <br>
                <p>
                    <form action="exams.php" method="POST">
                        <input type="hidden" id="id" name="id" value=<?php echo "$user_id"; ?>>
                        <input type="submit" value="See your examinations">
                    </form>
                </p>
                <br><a href="change_password.php"> Reset password </a>   
                <br><a href="home.php"> Back to home </a>
        
        
    </body>
</html>