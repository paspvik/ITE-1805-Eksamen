

<?php

require 'file_functions.php'; 

?>


<div>

<h1> Here you can upload.... </h1>

<html>
	<body>
	<form action="uploader.php" method="post" enctype="multipart/form-data">
		Description: <input type="text" name="description"><br>
		Author: <input type="text" name="author"><br>
		Tags: <input type="text" name="tags"><br>
		File: <input type="file" name="file">
		<button type="submit" name="upload"> Upload </button>
	</form>
	</body>
</html>
	<?php
		uploadForm($db);
	?>
</div>



<div>
	<h1> All the files that have been uploaded: </h1>
		<?php
			viewAllFiles($db);
		?>
</div>


asdsdasfdasfsaf

