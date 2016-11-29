<?php //register.php
session_start();
//require_once "dbLogin.php"; //Database Currently disabled

$connection = new mysqli($hn, $un, $pw, $db);
if ($connection->connect_error) die ( $connection->connect_error );

if (isset($_SESSION['username'])){
    //user logged in
    echo "<body><h1>Register Page</h1><p>Log out before register.</p>";
    echo <<<_END
    <a href='mainpage.php'>main page</a><br><br>

    <form action="logout.php">
    <input type="submit" value="Log me out" /> <!--Value: Name on button-->
    </form></body></html>
_END;
}

else {

    //Display form
    echo <<<_END1
<html>
<head>
    <title>Register Page</title>
</head>
<body>
    <h1>Register Page</h1>
    <form action = register.php method="post">
        Name: <input type="text" name="forename"><br>
        Username: <input type="text" name="username"><br>
        Password: <input type="text" name="password"><br>
        <input type="submit">
    </form>
    <br>
    <a href='mainpage.php'>main page</a><br>
</body>
</html>
_END1;


    //user has made an input
    if (isset($_POST['forename']) && isset($_POST['username']) && isset($_POST['password'])) {
        $forename = $_POST['forename'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        //Security measures
        $salt1 = "team4";
        $salt2 = $username;
        $pretoken = $salt1 . $salt2 . $password;

        echo "Pre-Token:<br>" . $pretoken; //debugging purposes

        //Apply hashing
        $token = hash('ripemd128', $pretoken);
        add_user($connection, $forename, $username, $token);

        echo "Added: " . $username;
    }
}


//functions
function add_user($connection, $fn, $un, $pw){
    $query = "INSERT INTO users VALUES('$fn','$un','$pw')";
    $result = $connection->query($query);
    if(!$result) die($connection->error);
}//end add user function

?>
