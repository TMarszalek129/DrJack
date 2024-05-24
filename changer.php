<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
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

            $servername = "mysql.agh.edu.pl";
            $username = "";
            $password = "";
            $dbname = "";

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
                    SET password = '.$hash_npass.' 
                    WHERE account_id =  '.$account_id.'";
                
            if($passed == 1){
                echo "Dopisano\n";
                mysqli_query($conn, $sql);
            }
            else
                echo "\nWrong email or password!!!\n";
                ?>   
                <br><a href="home.php"> Back to home </a>
        
        
    </body>
</html>