

<?php
/*
Sources:

https://stackoverflow.com/questions/8662535/trigger-php-function-by-clicking-html-link

*/
?>


<?php
require 'file_uploader/auth_pdo.php'; 
require 'file_uploader/file_functions.php'
?>



<center>
<?php

$stmt = "SELECT * FROM catalog ";


#Gets all the catalog levels and creates a link that when clicked passes the access level to viewByAccess to display the files associated with that level
foreach($db->query($stmt) as $row){

    echo "</br>";
    echo  '<a href="' . 'catalog.php?level='. $row['cat_id'] . '">' .  "<td>{$row['cat_name']}</td>" . '</a>'; #Creates a link with the cat_id and stores the url variable.
    echo "</br>";

    //Gets the cat_id from the link
    $level = $_GET['level'];
}
?>



<br>
<?php 


//Calls the function with the parameters passed from the variable level
    viewByAccess($db, $level);  
?>



</center>


