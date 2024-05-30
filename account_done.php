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
    $email = $_SESSION["email"];
    $pass = $_SESSION["pass"];
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
        if(empty($_POST["bdate"])){
            $dateErr = "You must enter your birthdate";
            
        }
        else{
            $bdate = format($_POST["bdate"]);
        }
        if(empty($_POST["sex"])){
            $sexErr = "You must enter your sex";
            
        }
        else{
            $sex = format($_POST["sex"]);
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
        $sql = "INSERT INTO accounts(first_name, last_name, email, password, birth_date, sex)
                VALUES ('".$fname."', '".$lname."', '".$email."' , '".$hash_pass."', '".$bdate."', '".$sex."')";
        if(mysqli_query($conn, $sql))
            echo "Dopisano";
        else
            echo "Blad: ".$sql."<br>".mysqli_error($conn);
    }
    
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