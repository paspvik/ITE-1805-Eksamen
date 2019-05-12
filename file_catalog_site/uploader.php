

<?php
require '../Classes/file.php';
?>


<div>
<h1> Here you can upload files </h1>

<html>
	<body>
	<form action="uploader.php" method="post" enctype="multipart/form-data">
		Description: <input type="text" name="description"><br>
		Author: <input type="text" name="author"><br>
		File: <input type="file" name="file"> <br>
		
		<button type="submit" name="upload"> Upload </button>
	</form>
	</body>
</html>
	<?php
		$file = new File();
		$file->uploadForm();    
	?>
</div>


