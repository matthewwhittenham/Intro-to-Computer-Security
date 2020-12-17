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
            $rootUser = "root";
            $db = "socnet";
            $rootPassword = "";

            $conn = new mysqli($servername, $rootUser, $rootPassword, $db);

            $email = htmLawed($_POST['txtEmail'], array('safe'=>1, 'deny_attribute'=>'style'));
            $password = htmLawed($_POST['txtPassword'], array('safe'=>1, 'deny_attribute'=>'style'));

            if ($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }

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
                        if (password_verify($password, $userRow['Password']))
                        {
                            echo "<form action='passwordUpdateForm.php' method='POST'>";
                            echo "<pre>"; // check in Google what pre does
                            echo "Hi " . $userRow['Name'] . "!";
                            echo "<br/> Welcome to our restaurant! Your account with us is active, so you may now call us to make an order. To edit your account settings, please select an option below:";
                            echo "<br/>"; 
                            echo "<br/>"; 
                            echo "<input type='submit' value='Update a Password'>";
                        }
                        else
                        {
                            echo "Wrong password";
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