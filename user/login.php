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
    #Including the class
    include_once('../Classes/user.php');

    #Checking if the form is submitted
    if(isset($_POST['login_button'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        #Initializing the login method
        $object = new User();
        $object->Login($username,$password);
    }
    ?>


</body>
</html>