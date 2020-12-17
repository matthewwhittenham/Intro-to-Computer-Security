<?php
    include 'tokenGenerator.php';
    session_start();
    
    echo "<head>";
    echo "<script src='https://www.google.com/recaptcha/api.js' async defer></script>";
    echo "</head>";

    echo "<body>";
    echo "<form action='customerLoginCheck.php' method='POST'>";
    echo "<pre>";
    echo "Email: ";
    echo "<input name='txtEmail' type='text' />";
    echo "<br/>";
    echo "<br/>";

    echo "Password ";
    echo "<input name='txtPassword' type='password' />";
    echo "<br/>";
    echo "<br/>";

    echo "<div class='g-recaptcha' data-sitekey='6LdcXQcaAAAAAK_wuq7luUp05YP0LrWeELIrgxVN'></div>";
    echo "<br/>";
    echo "<br/>";

    echo "<input type='submit' value='Login'/>";
    echo "<input type='hidden' name='csrf_token' value='" . generateToken() . "'/>";
    echo "</form>";
    echo "</body>";
    
?>