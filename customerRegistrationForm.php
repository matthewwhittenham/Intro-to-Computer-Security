<?php
include 'tokenGenerator.php';
session_start();

echo "<head>";
echo "<script src='https://www.google.com/recaptcha/api.js' async defer></script>";
echo "</head>";

echo "<body>";
echo "<form action='customerRegistrationCheck.php' method='post'>";
echo "<pre>";
echo "Name: ";
echo "<input name='txtName' type='text'/>";
echo "<br/>";
echo "<br/>";

echo "Date of Birth: ";
echo "<input name='datDob' type='date'/>";
echo "<br/>";
echo "<br/>";

echo "Address: ";
echo "<textarea name='txtAddress' type='text' rows='5' cols='20'></textarea>";
echo "<br/>";
echo "<br/>";

echo "Email: ";
echo "<input name='txtEmail' type='email'/>";
echo "<br/>";
echo "<br/>";

echo "Password: ";
echo "<input name='txtPassword' type='password'/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";

echo "<div class='g-recaptcha' data-sitekey='6LdcXQcaAAAAAK_wuq7luUp05YP0LrWeELIrgxVN'></div>";
echo "<br/>";
echo "<br/>";

echo "<input type='submit' value='Register'/>";
echo "<input type='hidden' name='csrf_token' value='" . generateToken() . "'/>";

echo "</pre>";
echo "</form>";

echo "</body>";
?>

