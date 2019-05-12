

<?php
require '../Classes/file.php';
$file = new File();
?>


<div>
<h1> Here you can upload files </h1>

<html>
	<body>
	<form action="uploader.php" method="post" enctype="multipart/form-data">
		
		<label> Description: </label>  
			<input type="text" name="description"><br>
		<label> Author:</label> 
			<input type="text" name="author"><br>
		<label> Access Level: </label>
			<select name="access_level">
				<option value= 1> 1 </option>
				<option value= 2> 2 </option>
			</select>
		<br>
		<label>File:</label>  
			<input type="file" name="file"> <br>
		
		<button type="submit" name="btn_submit" value= "upload"> Upload </button>
	</form>
	</body>

</html>
	<?php
		$file->uploadForm();    
	?>
</div>


