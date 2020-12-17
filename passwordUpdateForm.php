<?php
include 'tokenGenerator.php';
session_start();

echo "<head>";
echo "<script src='https://www.google.com/recaptcha/api.js' async defer></script>";
echo "</head>";

echo "<body>";
echo "<form action='passwordUpdateCheck.php' method='post'>";
echo "<pre>";
echo "Email: ";
echo "<input name='txtEmail' type='email'/>";
echo "<br/>";
echo "<br/>";

echo "Old Password: ";
echo "<input name='txtOldPassword' type='password'/>";
echo "<br/>";
echo "<br/>";

echo "New Password: ";
echo "<input name='txtNewPassword' type='password'/>";
echo "<br/>";
echo "<br/>";

echo "Re-enter New Password: ";
echo "<input name='txtNewPassword2' type='password'/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";

echo "<div class='g-recaptcha' data-sitekey='6LdcXQcaAAAAAK_wuq7luUp05YP0LrWeELIrgxVN'></div>";
echo "<br/>";
echo "<br/>";

echo "<input type='submit' value='Update'>";
echo "<input type='hidden' name='csrf_token' value='" . generateToken() . "'/>";

echo "</pre>";
echo "</form>";
echo "</body>";

?>

