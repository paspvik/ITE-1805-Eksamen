<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Project ITE1805</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="login_style.css" rel="stylesheet" type="text/css"> <!-- Source for css -->
</head>
<body>


<!-- Source for form setup https://codeshack.io/secure-registration-system-php-mysql/    -->
    <div class="login">
			<h1>Login</h1>
			<form action="login.php" method="post" autocomplete="off">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<input type="submit" name="login_button" value="Login">
			</form>
        </div>
        

        <div id="not_reg">
                <h1 class="account_text">Not registered?</h1> 
                <a href="reg.php">Sign up</a>
        </div>


    <?php


     /* Source php pdo form https://stackoverflow.com/questions/44771540/how-to-insert-form-data-into-pdo-using-prepared-statements?fbclid=IwAR3MXOtPOq5VJ8qxOqN1-WNBVNAZxYoE3xhgjDTtBXr-xmCOmdoItu5LI1c    -->
        Source php security https://codeshack.io/secure-registration-system-php-mysql/     -->     */   

    $servername = 'kark.uit.no';
    $username = 'stud_v19_aspvikp';
    $password = 'mariadb@uit';
    $dbname = 'stud_v19_aspvikp';

    try { 
        $con = new PDO("mysql:host=$servername;dbname=$dbname", $username,
        $password);

        // set the PDO error mode to exception
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        /* SOURCE login https://youtu.be/b-2_Y53CTYA */
       /*  SOURCE PASSWORD_VERIFY https://stackoverflow.com/questions/29777684/how-do-i-use-password-hashing-with-pdo-to-make-my-code-more-secure */


       if (isset($_POST['username'], $_POST['password'])){

                $stmt = $con->prepare('SELECT * FROM users WHERE username= :username');
                $stmt->bindParam(':username', $_POST['username']);
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
                        $verify_password = password_verify($_POST['password'],$array_user_password); #Checks password input against hash, returns true if correct
                        
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
    
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }
    $con = null;

    ?>


</body>
</html>