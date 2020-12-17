<?php
  function generateToken() 
   {
    // Check if a token is present for the current session
    if(!isset($_SESSION["csrf_token"]))    //isset return false if value not set
     {
        $token = bin2hex(random_bytes(64));   // token generation , md5(time()), hash/cryptography
        $_SESSION["csrf_token"] = $token;
    } 

   else 
     {
        $token = $_SESSION["csrf_token"];        // Reuse the token
     }
    return $token;
}
?>