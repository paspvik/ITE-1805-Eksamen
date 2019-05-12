
<link rel="stylesheet" type="text/css" href="file_uploader/table_styles.css">

<?php
require '../Classes/file.php';
?>



<?php

if (isset($_GET['view'])) {
    $view = $_GET['view'];
}
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

<?php
    $file = new File();
    $file->accessSingleFile($view);
?>


