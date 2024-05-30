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

            $passed = 0;
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                if(empty($_POST["email"])){
                    $emailErr = "You must enter your e-mail";
                    
                }
                else
                    $email = format($_POST["email"]);

                if(empty($_POST["apassword"])){
                    $apassErr = "You must enter your actual password";
                    
                }
                else{
                    $apass = format($_POST["apassword"]);
                    $hash_apass = password_hash($apass, PASSWORD_DEFAULT);
                }
                if(empty($_POST["npassword"])){
                    $npassErr = "You must enter your new password";
                    
                }
                else{
                    $npass = format($_POST["npassword"]);
                    $hash_npass = password_hash($npass, PASSWORD_DEFAULT);
                }
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
                    if($row["email"] == $email && password_verify($apass, $row["password"])){
                        $passed = 1;
                        $account_id = $row["account_id"];
                    }
                }
            }
        
            
            $sql = "UPDATE accounts
                    SET password = '$hash_npass' 
                    WHERE accounts.account_id =  '$account_id'";
                
            if(mysqli_query($conn, $sql)){
                echo "Dopisano\n";
            }
            else
                echo "Blad: ".$sql."<br>".mysqli_error($conn);
                ?>   
                <br><a href="home.php"> Back to home </a>
        
        
    </body>
</html>