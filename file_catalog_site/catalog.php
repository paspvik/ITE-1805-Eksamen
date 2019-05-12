
<link rel="stylesheet" type="text/css" href="file_uploader/table_styles.css">

<?php
require 'file_uploader/file.php';
?>


<center>
<?php
    //Gets the cat_id from the link to create the variable to pass on to the viewByAccess function
    $level = $_GET['level'];
    $file = new File();
    $file->createLinks($level); 
?>

<table border="1" cellspacing="" cellpadding=""> 
    <tr> 
	    <th> <font face="Arial">ID</font> </td>
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


