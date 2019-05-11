<?
/* SOURCE OOP https://www.youtube.com/watch?v=B1_yi7HM0Cg */
/* SOURCE php pdo form https://stackoverflow.com/questions/44771540/how-to-insert-form-data-into-pdo-using-prepared-statements?fbclid=IwAR3MXOtPOq5VJ8qxOqN1-WNBVNAZxYoE3xhgjDTtBXr-xmCOmdoItu5LI1c    -->
/* SOURCE php security https://codeshack.io/secure-registration-system-php-mysql/     -->     */   
/* SOURCE login https://youtu.be/b-2_Y53CTYA */
/* SOURCE PASSWORD_VERIFY https://stackoverflow.com/questions/29777684/how-do-i-use-password-hashing-with-pdo-to-make-my-code-more-secure */
/* SOURCE php pdo registration https://stackoverflow.com/questions/44771540/how-to-insert-form-data-into-pdo-using-prepared-statements?fbclid=IwAR3MXOtPOq5VJ8qxOqN1-WNBVNAZxYoE3xhgjDTtBXr-xmCOmdoItu5LI1c    -->
/* SOURCE php security https://codeshack.io/secure-registration-system-php-mysql/     -->     */   
/* SOURCE PDO Username check  https://stackoverflow.com/questions/23305300/check-if-username-exists-pdo -->  */
/* SOURCE PHPMAILER -  https://github.com/PHPMailer/PHPMailer/blob/master/examples/gmail.phps */
/* SOURCE logout https://youtu.be/b-2_Y53CTYA */
/* SOURCE PDO SESSION https://youtu.be/b-2_Y53CTYA */ 
/* SOURCE email activation https://codeshack.io/secure-registration-system-php-mysql/   */ 

#Getting the class for connecting to the sql database
include_once('../Classes/connection.php');

class User {

    private $db;

    #The method creates the connection to the database
    public function __construct() {
        $this->db = new Connection();
        $this->db = $this->db->dbConnect();
    }

    #The method for used to login the user
    public function Login($username,$password) {
        if (isset($username, $password)){
            
            $stmt = $this->db->prepare('SELECT * FROM users WHERE username= :username');
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $usernames = $stmt->fetchAll(); #Making an array out of the returned usernames
                  
            #If there are no rows in the array
            if ($stmt->rowcount() == 0) {
                #No match for the username in the database
                echo '<script>alert("Username or password is wrong, please try again!");</script>'; 

            }

            else {
                    $array_user = $usernames[0]; #Choosing the first user in the array
                    $array_user_password = $array_user["password"]; #saving the hash of the first user
                    $verify_password = password_verify($password,$array_user_password); #Checks password input against hash, returns true if correct
                    
                    if($verify_password == true) {
                        //login was succsessful
                        session_start();
                        $_SESSION["username"] = $_POST["username"];
                        header("location:member.php");
                    }

                    else {
                        //invalid username or password
                        echo '<script>alert("Username or password is wrong, please try again!");</script>'; 


                    } 
            }
        }

    }

    #The method used for registration
    public function Registration($username,$password,$email){

        // Now we check if the data was submitted, isset() function will check if the data exists.
        if (!isset($username, $password, $email)) { #VURDER Å KOMMENTERE UT?!?!?!?!??!?!!??!?!?!?!?!?!
            // Could not get the data that should have been sent.
             die ('');
            }
            // Make sure the submitted registration values are not empty.
        if (empty($username) || empty($password) || empty($email)) {
            // One or more values are empty.
            die('<script>alert("Please complete the registration form");</script>');
            }
            
        //Checking for error ELLER LAGE ISSET UNAME,PSWD - LAGE EN VARIABEL FOR ERROR??!?!?!??!???!???!??!?!
        /* Source PDO Username check  https://stackoverflow.com/questions/23305300/check-if-username-exists-pdo -->  */
        if(!isset($error)){
            //no error - then check if username is in use
            $stmt = $this->db->prepare("SELECT username FROM users WHERE username = :username ");
            $stmt->bindParam(':username', $username);
            $stmt->execute(); 

            if($stmt->rowCount() > 0){
                #Alert appears when username already exsist
                echo '<script>alert("Username exists, please choose something else!");</script>'; 
                
            } else {
                    // Insert new account
                    // Username doesnt exists, insert new account
                    /* Source verification of mail - https://codeshack.io/secure-registration-system-php-mysql/ */
                    if ($stmt = $this->db->prepare('INSERT INTO users (username, password, email, activation_code) VALUES (:username,:password,:email,:activation_code)')) {
                        // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
                        $password = password_hash($password, PASSWORD_DEFAULT); 
                        #Binding variable/placeholder to avoid sql injection
                        $stmt-> bindParam(':username', $username);
                        $stmt-> bindParam(':password', $password);
                        $stmt-> bindParam(':email', $email);
                        $uniqid = uniqid();
                        $stmt-> bindParam(':activation_code', $uniqid);
                        $stmt->execute();

                    /* SOURCE PHPMAILER -  https://github.com/PHPMailer/PHPMailer/blob/master/examples/gmail.phps */

                        $activate_link = 'INSERT_ROOT_HOST_ADDRESS/user/activate_mail.php?email=' . $email . '&code=' . $uniqid; #Activation link
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
                        $mail->addAddress($email); #Email receiver 
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

    #The method for the logout function
    public function Logout() {

        session_start();
        #Stopping the session
        session_destroy();
        #Sending the user back to login
        header("location:login.php");

    }

    #The method for the "member site"
    public function Member() {

       #Starting the users session 
       session_start();
  
       if(isset($_SESSION["username"])) {

           $stmt = $this->db->prepare('SELECT * FROM users WHERE username= :username');
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

    #The method for activating the email
    public function Activate_mail() {
        // First we check if the email and code exists...
        if (isset($_GET['email'], $_GET['code'])) {
            if ($stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email AND activation_code = :activation_code')) {
                $stmt-> bindParam(':email', $_GET['email']);
                $stmt-> bindParam(':activation_code', $_GET['code']);
                $stmt->execute();

                // Store the result so we can check if the account exists in the database.
                #$stmt->store_result();
                if ($stmt->rowCount() > 0) {
                    // Account exists with the requested email and code.
                    if ($stmt = $this->db->prepare('UPDATE users SET activation_code = :new_code WHERE email = :email AND activation_code = :activation_code')) {
                        // Set the new activation code to 'activated', this is how we can check if the user has activated their account.
                        $newcode = 'activated';
                        $stmt-> bindParam(':new_code', $newcode);
                        $stmt-> bindParam(':email', $_GET['email']);
                        $stmt-> bindParam(':activation_code', $_GET['code']);
                        $stmt->execute();
                        echo 'Your account is now activated, you can now login!<br><a href="login.php">Login</a>';
                    }
                } else {
                    echo 'The account is already activated or doesn\'t exist!';
                }
            }
            }
    }

    
    










}