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
        $email = htmLawed($_POST['txtEmail'], array('safe'=>1, 'deny_attribute'=>'style')); 
        $oldPassword = htmLawed($_POST['txtOldPassword'], array('safe'=>1, 'deny_attribute'=>'style')); 
        $newPassword1 = htmLawed($_POST['txtNewPassword'], array('safe'=>1, 'deny_attribute'=>'style'));
        $newPassword2 = htmLawed($_POST['txtNewPassword2'], array('safe'=>1, 'deny_attribute'=>'style')); 


        //  INSERT query   , check hash variable in the Values statement

        $userQuery = "SELECT * FROM customerdetails";
        $userResult = $conn->query($userQuery);

        $userFound = 0;
            

        echo "<table border='1'>";
        if ($userResult->num_rows > 0)
        {
          while ($userRow = $userResult->fetch_assoc())
          {
            if ($userRow['Email'] == $email)
            {
              $userFound = 1;
              if (password_verify($oldPassword, $userRow['Password']))
              {
                if ($newPassword1 == $newPassword2)
                {
                  $encryptedPassword = password_hash($newPassword1, PASSWORD_BCRYPT, array("cost" => 10));
                  $updateQuery = $conn->prepare("UPDATE customerdetails SET Password = ? WHERE Email = ?");
                  $updateQuery->bind_param("ss", $encryptedPassword, $email);
                  if ($updateQuery->execute() == TRUE)
                  {
                    echo "<form action='customerLoginForm.php' method='POST'>";
                    echo "<pre>"; // check in Google what pre does
                    echo "Password Updated!";
                    echo "<br/>"; 
                    echo "<br/>"; 
                    echo "<input type='submit' value='Return to Login'>";
                  }
                  else
                  {
                    echo "Password not updated successfully";
                  }
                }
                else
                {
                  echo "Passwords do not match!";
                }
              }
              else
              {
                echo "Old Password Incorrect!";
              }
            }
          }
        }

        if ($userFound == 0)
        {
          echo "This user was not found in our database";
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

