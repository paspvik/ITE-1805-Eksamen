
<link rel="stylesheet" type="text/css" href="../Classes/table_styles.css">

<?php
require '../Classes/file.php';
error_reporting(0);
session_start();
?>


<center>
<?php
    //Gets the cat_id from the link to create the variable to pass on to the viewByAccess function
    
    
    #The IF is for a simple fix for the session problem
    if(isset($_SESSION["username"]))
    {   
        $level = $_GET['level'];
        $file = new File();
        $accsess_level = $file->get_access_level();
        $file->createLinks($level); 
    } else {
        $level = $_GET['level'];
        if ($level >= 2) {
            echo "Sorry, you dont have the right access level";
        } else {
            $level = $_GET['level'];
            session_start();
            $file = new File();
            $accsess_level = $file->get_access_level();
            $file->createLinks($level);   
        }

    }
 

?>

<table border="1" cellspacing="" cellpadding=""> 
    <tr> 
	    <th> <font face="Arial">ID </td>
		<th> <font face="Arial">Filename</font> </td>  
		<th> <font face="Arial">Description</font> </td> 
		<th> <font face="Arial">Author</font> </td> 
	    <th> <font face="Arial">Tags</font> </td> 
		<th> <font face="Arial">Date Created</font> </td> 			  
        <th> <font face="Arial">Download</font> </td> 
	 </tr>


<br>
<?php 
    //Calls the function with the parameters passed from the variable level
    $file->viewByAccess($level);    
?>

</center>


