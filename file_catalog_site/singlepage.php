
<link rel="stylesheet" type="text/css" href="../Classes/table_styles_single.css">

<?php
require '../Classes/file.php';
include_once('../Classes/comment.php')
?>



<?php

if (isset($_GET['view'])) {
    $view = $_GET['view'];
}
?>

<table border="1" cellspacing="" cellpadding="" id="single"> 
    <tr> 
	    <th> <font face="Arial">ID</font> </td>
		<th> <font face="Arial">Filename</font> </td>  
		<th> <font face="Arial">Description</font> </td> 
		<th> <font face="Arial">Author</font> </td> 
	    <th> <font face="Arial">Tags</font> </td> 
		<th> <font face="Arial">Date Created</font> </td> 			  
        <th> <font face="Arial">Download</font> </td> 
	 </tr>

<?php
    $file = new File();
	$file->accessSingleFile($view);
	$file->incrementView($view);
	include_once("../comment/new_comment.php");
	

?>


