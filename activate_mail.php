<?php
// Change this to your connection info.

$servername = 'kark.uit.no';
$username = 'stud_v19_aspvikp';
$password = 'mariadb@uit';
$dbname = 'stud_v19_aspvikp';

#  <!-- Source email activation https://codeshack.io/secure-registration-system-php-mysql/     -->     

try {
    $con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// First we check if the email and code exists...
if (isset($_GET['email'], $_GET['code'])) {
    if ($stmt = $con->prepare('SELECT * FROM users WHERE email = :email AND activation_code = :activation_code')) {
        $stmt-> bindParam(':email', $_GET['email']);
        $stmt-> bindParam(':activation_code', $_GET['code']);
		$stmt->execute();
		// Store the result so we can check if the account exists in the database.
		#$stmt->store_result();
		if ($stmt->rowCount() > 0) {


			// Account exists with the requested email and code.
			if ($stmt = $con->prepare('UPDATE users SET activation_code = :new_code WHERE email = :email AND activation_code = :activation_code')) {
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

catch(PDOException $e)
{
    echo "Error: " . $e->getMessage();
}
$con = null;


// Try and connect using the info above.

?>



