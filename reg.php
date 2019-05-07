<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Project ITE1805</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link href="reg_style.css" rel="stylesheet" type="text/css"> <!-- Source for css -->

    </head>
    <body>
        
        <!-- Source for form setup https://codeshack.io/secure-registration-system-php-mysql/    -->
        <div class="register">
                    <h1>Welcome - Please registrer</h1>
                    <form action="reg.php" method="post" autocomplete="off">
                        <label for="username">
                            <i class="fas fa-user"></i>
                        </label>
                        <input type="text" name="username" placeholder="Username" id="username" required>
                        <label for="password">
                            <i class="fas fa-lock"></i>
                        </label>
                        <input type="password" name="password" placeholder="Password" id="password" required>
                        <label for="email">
                            <i class="fas fa-envelope"></i>
                        </label>
                        <input type="email" name="email" placeholder="Email" id="email" required>
                        <input type="submit" name="submit_button" value="Sign up">
                    </form>     
                </div>

            <div id="already_login">
                <h1 class="account_text">Already have an account?</h1> 
                <a href="login.php">Login</a>
            </div>


        <?php
        $servername = 'kark.uit.no';
        $username = 'stud_v19_aspvikp';
        $password = 'mariadb@uit';
        $dbname = 'stud_v19_aspvikp';


        /* Source php pdo registration https://stackoverflow.com/questions/44771540/how-to-insert-form-data-into-pdo-using-prepared-statements?fbclid=IwAR3MXOtPOq5VJ8qxOqN1-WNBVNAZxYoE3xhgjDTtBXr-xmCOmdoItu5LI1c    -->
        Source php security https://codeshack.io/secure-registration-system-php-mysql/     -->     */   
            
        try {

            $con = new PDO("mysql:host=$servername;dbname=$dbname", $username,
            $password);

            // set the PDO error mode to exception
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            

            // Now we check if the data was submitted, isset() function will check if the data exists.
            if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) { #VURDER Å KOMMENTERE UT?!?!?!?!??!?!!??!?!?!?!?!?!
                // Could not get the data that should have been sent.
                die ('');
            }
            // Make sure the submitted registration values are not empty.
            if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
                // One or more values are empty.
                die('<script>alert("Please complete the registration form");</script>');
            }
            
        //Checking for error ELLER LAGE ISSET UNAME,PSWD - LAGE EN VARIABEL FOR ERROR??!?!?!??!???!???!??!?!
        /* Source PDO Username check  https://stackoverflow.com/questions/23305300/check-if-username-exists-pdo -->  */
        if(!isset($error)){
            //no error - then check if username is in use
            $stmt = $con->prepare("SELECT username FROM users WHERE username = :username ");
            $stmt->bindParam(':username', $_POST['username']);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                #Alert appears when username already exsist
                echo '<script>alert("Username exists, please choose something else!");</script>'; 
                
            } else {
                    // Insert new account
                    // Username doesnt exists, insert new account
                    /* Source verification of mail - https://codeshack.io/secure-registration-system-php-mysql/ */
                    if ($stmt = $con->prepare('INSERT INTO users (username, password, email, activation_code) VALUES (:username,:password,:email,:activation_code)')) {
                        // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
                        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
                        #Binding variable/placeholder to avoid sql injection
                        $stmt-> bindParam(':username', $_POST['username']);
                        $stmt-> bindParam(':password', $password);
                        $stmt-> bindParam(':email', $_POST['email']);
                        $uniqid = uniqid();
                        $stmt-> bindParam(':activation_code', $uniqid);
                        $stmt->execute();

                    /* SOURCE PHPMAILER -  https://github.com/PHPMailer/PHPMailer/blob/master/examples/gmail.phps */

                        $activate_link = 'INSERT_ROOT_HOST_ADDRESS/activate_mail.php?email=' . $_POST['email'] . '&code=' . $uniqid; #Activation link
                        $message = '<p>Please click the following link to activate your account: <a href="' . $activate_link . '">' . $activate_link . '</a></p>'; #Email message
                        
                        require 'PHPMailer/PHPMailerAutoload.php';
                        $mail = new PHPMailer;
                        $mail->isSMTP(); #Comment out if you are using liveserver
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPOptions = array(
                            'ssl' => array ('verfiy_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true)
                        );
                        $mail->Port = 587;
                        $mail->SMTPAuth = true;
                        $mail->SMTPSecure='tls';
                        $mail->SMTPDebug  = 0; #Should be 0 if not debugging
                        $mail->Username = 'project1805ite@gmail.com';
                        $mail->Password = 'project18051234';
                        $mail->setFrom('project1805ite@gmail.com'); #Email sender
                        $mail->addReplyTo('project1805ite@gmail.com'); #Reply for email sender
                        $mail->addAddress($_POST['email']); #Email receiver 
                        $mail->isHTML(true);
                        $mail->Subject = 'Project DWA_PWA'; #Subject of the email
                        $mail->Body= $message; 

                        if (!$mail->send()) {
                            echo '<script>alert("Something went wrong, please try again");</script>' . $mail->ErrorInfo; 
                        } else {

                            echo '<script>alert("Registration was successful, please check your mail for activation details!");</script>'; 
                        }


                    } else {
                        // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
                        echo '<script>alert("Could not prepare statement!");</script>'; 
                    }
                }
                #$stmt->close();
            } else {
                // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
                echo '<script>alert("Could not prepare statement!");</script>'; 
            }
        
        }

        catch(PDOException $e)
        {
            echo "Error: " . $e->getMessage();
        }
        $con = null;


        ?>

    </body>
</html>