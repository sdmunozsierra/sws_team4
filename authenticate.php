<?php // authenticate.php
//require_once 'dbLogin.php'; //Database Login will be disabled while we set it up
$connection = new mysqli($hn, $un, $pw, $db);
if ($connection->connect_error)
    die ( $connection->connect_error );

//POST FROM LOGIN.PHP
if(isset($_POST['username']) && isset($_POST['password'])){
    $un_temp = $_POST['username'];
    $pw_temp = $_POST['password'];


    $query = "SELECT * FROM users WHERE username='$un_temp'"; //create query
    $result = $connection->query ( $query ); //save query

    if (! $result) //no query?
        die ( $connection->error ); //kill
    elseif ($result->num_rows) { //else
        $row = $result->fetch_array ( MYSQLI_NUM );
        $result->close (); //destroy query
        $salt1 = "team4";
        $salt2 = "$un_temp";
        $token = hash ( 'ripemd128', "$salt1$salt2$pw_temp" ); //salt and hash
        if ($token == $row [2]) { //password is on row2
            //IMPORTANT
            session_start (); //CREATE A SESSION!!!
            //IMPORTANT
            $_SESSION ['username'] = $un_temp;  //row1
            $_SESSION ['password'] = $pw_temp;  //row2
            $_SESSION ['forename'] = $row [0];  //row0
            echo " Hello $row[0], you are now logged in as '$row[1]'";
            die ( "<p><a href='continue.php'>Click here to continue</a></p>" ); //go to continue.php (debugging purposes)
        } else
            die ( "Invalid username/password combination" );
    } else
        die ( "Invalid username/password combination" );
}
else {
    die ( "<p><a href='login.php'>Click here to go to Login Page</a></p>" );
}
$connection->close (); //kill connection
//functions
function mysql_entities_fix_string($connection, $string) {
    return htmlentities ( mysql_fix_string ( $connection, $string ) );
}
function mysql_fix_string($connection, $string) {
    if (get_magic_quotes_gpc ())
        $string = stripslashes ( $string );
    return $connection->real_escape_string ( $string );
}
