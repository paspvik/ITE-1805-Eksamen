<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Project ITE1805</title>
</head>
<body>

    <?php

   /* Source session https://youtu.be/b-2_Y53CTYA */ 
    session_start();
    $servername = 'kark.uit.no';
    $username = 'stud_v19_aspvikp';
    $password = 'mariadb@uit';
    $dbname = 'stud_v19_aspvikp';

    try {

        $con = new PDO("mysql:host=$servername;dbname=$dbname", $username,
        $password);

        // set the PDO error mode to exception
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if(isset($_SESSION["username"])) {

            $stmt = $con->prepare('SELECT * FROM users WHERE username= :username');
            $stmt->bindParam(':username', $_SESSION["username"]); 
            $stmt->execute();
            $usernames = $stmt->fetchAll();
            $array_user = $usernames[0]; #Choosing the first user in the array
            $array_user_activation = $array_user["activation_code"]; #Saving the activation status

            #Checks if user has status activated
            if($array_user_activation == 'activated') {

                #Login was successful
                echo '<h3>Login Success, Welcome - '.$_SESSION["username"].'</h3>';
                echo '</br><br /><a href = "logout.php">Logout</a>';
            } else {

                #Login was not successful
                echo '<h3>Your account is not activated, please check your email and the spam folder</h3>';
                echo '</br><br /><a href = "login.php">Go back to login</a>';
                
            }
         }
     
         else {
             #If user is not logged in, return to login site
             header("location:login.php");
         }

    }



    catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $con = null;



    ?>


</body>
</html>