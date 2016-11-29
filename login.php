<?php //login.php

echo <<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log-in Page</title>
</head>
<body>
    <h1>Login Page</h1>
    <form action = authenticate2.php method="post">
        Username: <input type="text" name="username"><br>
        Password: <input type="text" name="password"><br>
        <input type="submit">
    </form>
_END;

