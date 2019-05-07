<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ITE1805</title>
</head>
<body>

<?php

$servername = 'kark.uit.no';
$username = 'stud_v19_aspvikp';
$password = 'mariadb@uit';
$dbname = 'stud_v19_aspvikp';

try {

    if (isset($_GET['id'])) {
        #Getting the ID from the url
        $comID = $_GET['id']; 

        $con = new PDO("mysql:host=$servername;dbname=$dbname", $username,
        $password);

        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $con->prepare('UPDATE comments SET status=:status WHERE comID = :comID'); 
        $status = 'deleted';
        $stmt-> bindParam(':status', $status);
        $stmt-> bindParam(':comID', $comID);
        $stmt->execute();

        echo "The comment has been removed";




    } else {
        echo '<h1>Something went wrong, please try again</h1>';
        echo '<a href="member.php">Go back to member page</a>';
    }



}





catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$con = null;



?>



    
</body>
</html>