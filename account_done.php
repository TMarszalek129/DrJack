<?php
    session_start();
    function format($dane)
    {
        $dane = trim($dane);
        $dane = stripslashes($dane);
        $dane = htmlspecialchars($dane);
        return $dane;
    }

    
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(empty($_POST["fname"])){
            $fnameErr = "You must enter your first name";
            
        }
        else
            $fname = format($_POST["fname"]);

        if(empty($_POST["lname"])){
            $lnameErr = "You must enter your last name";
            
        }
        else{
            $lname = format($_POST["lname"]);
        }
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

    $servername = $_SESSION["servername"];
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $dbname = $_SESSION["dbname"];

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if(!$conn)
        die("Connection failed: ".mysqli_connect_error());
    
    $sqlSelect = "SELECT * FROM accounts";

    $result = mysqli_query($conn, $sqlSelect);
    $in_base = 0;
    if (mysqli_num_rows($result) > 0) {
        
        while($row = mysqli_fetch_assoc($result)) {
            if($row["email"] == $email && password_verify($pass, $row["password"]))
                $in_base = 1;    
        }
        } 
    
    if($in_base == 0){
        $sql = "INSERT INTO accounts(first_name, last_name, email, password)
                VALUES ('".$fname."', '".$lname."', '".$email."' , '".$hash_pass."')";
        if(mysqli_query($conn, $sql))
            echo "Dopisano";
        else
            echo "Blad: ".$sql."<br>".mysqli_error($conn);
    }
    
    ?>