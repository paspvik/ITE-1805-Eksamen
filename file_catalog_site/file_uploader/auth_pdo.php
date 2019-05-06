


<?php

$host = "kark.uit.no";
$dbname = "stud_v19_aspvikp";
$username = "stud_v19_aspvikp";
$password = "mariadb@uit";


try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username,
        $password);
}


catch(PDOException $e){

	print($e->getMessage());
        }
        
?>

