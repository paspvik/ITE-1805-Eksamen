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
        #Including the class
        include_once('../Classes/user.php');
       
        #Checking if the form is submitted
        if(isset($_POST['submit_button'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        #Initializing the register method
        $object = new User();
        $object->Registration($username,$password,$email);
    }
        ?>

    </body>
</html>