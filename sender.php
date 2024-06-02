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
        function format($dane)
            {
                $dane = trim($dane);
                $dane = stripslashes($dane);
                $dane = htmlspecialchars($dane);
                return $dane;
            }
        function randomPassword() { // from https://stackoverflow.com/questions/6101956/generating-a-random-password-in-php
            $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, strlen($alphabet)-1);
                $pass[$i] = $alphabet[$n];
            }
            return implode($pass);
        }

            $passed = 0;
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                if(empty($_POST["email"])){
                    $emailErr = "You must enter your e-mail";
                    
                }
                else
                    $email = format($_POST["email"]);
            }

            $sqlSelect = "SELECT * FROM accounts";

            $servername = $_SESSION["servername"];
            $username = $_SESSION["username"];
            $password = $_SESSION["password"];
            $dbname = $_SESSION["dbname"];

            $conn = mysqli_connect($servername, $username, $password, $dbname);
            
            if(!$conn)
                die("Connection failed: ".mysqli_connect_error());

            $result = mysqli_query($conn, $sqlSelect);

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    if($row["email"] == $email){
                        $passed = 1;
                        $account_id = $row["account_id"];
                        $new_password = randomPassword();
                        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    }
                }
            }
        
            
            $sql = "UPDATE accounts
                    SET password = '$new_password_hash' 
                    WHERE accounts.account_id =  '$account_id'";
            
            
            
            
            $msg = "Your new password here: $new_password";
            
                
            if(mysqli_query($conn, $sql)){
                echo "Password was changed<br>";
                echo "Password was sent - email: $email<br>";
                $headers = "From: drJack@drJack.com\r\n";
                $headers .= "Reply-To: drJack@drJack.com\r\n";
                $headers .= "Return-Path: drJack@drJack.com\r\n";
                $headers .= "CC: drJack@drJack.com\r\n";
                $headers .= "BCC: drJack@drJack.com\r\n";
                mail($email,"Password was changed - do not reply", $msg, $headers);
            }
            else{
                echo "Error: <br>";
                echo "There is no account associated with this e-mail adress";
            }
                ?>   
                <br><a href="home.php"> Back to home </a>
        
        
    </body>
</html>