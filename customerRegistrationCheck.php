<?php
  include 'htmLawed.php';
  header("Content-Security-Policy: script-src 'self'");
  $secretKey = "6LdcXQcaAAAAAA3eV_ggFniOjNychn_RckbkNGQd";
  if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
  {
    $verifiedResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']);
    $decodedResponse = json_decode($verifiedResponse);
    if ($decodedResponse->success)
    {
      session_start();
      if (!hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"]))
      {
        // Reset token
        unset($_SESSION["csrf_token"]);
        die("CSRF token validation failed");
      }
      else
      {
        $servername = "localhost";
        $rootuser="root";
        $db="socnet";
        $rootpassword ="";
        // Create connection
        $conn = new mysqli($servername, $rootuser, $rootpassword, $db);
        // Check connection
        if ($conn->connect_error) 
        {
          die("Connection failed: " . $conn->connect_error);
        }

        //Values from form
        $name= htmLawed($_POST['txtName'], array('safe'=>1, 'deny_attribute'=>'style'));
        $dateOfBirth = htmLawed($_POST['datDob'], array('safe'=>1, 'deny_attribute'=>'style'));
        $address = htmLawed($_POST['txtAddress'], array('safe'=>1, 'deny_attribute'=>'style'));
        $email = htmLawed($_POST['txtEmail'], array('safe'=>1, 'deny_attribute'=>'style')); 
        $password = htmLawed($_POST['txtPassword'], array('safe'=>1, 'deny_attribute'=>'style')); 

        $encryptedPassword = password_hash($password, PASSWORD_BCRYPT, array("cost" => 10));

        //  INSERT query   , check hash variable in the Values statement 
        $userQuery = $conn->prepare("INSERT INTO customerdetails (Name, `Date of Birth`, Address, Email, Password) Values(?, ?, ?, ?, ?)");
        $userQuery->bind_param("sssss", $name, $dateOfBirth, $address, $email, $encryptedPassword);

        if ($userQuery->execute() == TRUE)
        {
          echo "<form action='customerLoginForm.php' method='post'>";
          echo "<pre>"; // check in Google what pre does
          echo "Customer Registered!";
          echo "<br/>"; 
          echo "<br/>"; 
          echo "<input type='submit' value='Click Here to Login'/>";
          echo "</pre>";
          echo "</form>";
        }
        else
        {
          echo "Customer not successfully registered. Please go back and try again.";
        }
      }
    }
    else
    {
      echo "reCAPTCHA failed. Please try again!";
    }
  }
  else
  {
    echo "Please tick the reCAPTCHA box!";
  }
 
?>

