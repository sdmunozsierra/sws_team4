<?php //logout.php

//Add banner

echo "<br><p>Thank you for using the system. You have been logged out.</p>";
echo "<br><p>If you are finished, please <em>close your browser to protect your privacy.</em></p>";

session_start();
session_destroy();
header('Location: homepage.php'); //redirect to main page
exit;
