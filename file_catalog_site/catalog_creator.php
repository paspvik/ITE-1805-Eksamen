

<?php
    require 'file_uploader/file_functions.php'; 
?>



<h1> Here you can create catalogs.... </h1>

<html>
	<body>
	<form action="catalog_creator.php" method="post" enctype="multipart/form-data">
		Catalog Name: <input type="text" name="cat_name"><br>
		<button type="submit" name="create"> Create </button>
	</form>
	</body>
</html>
	<?php
		catalogCreator($db);
	?>
</div>



<div>
	<h1> All the of the catalogs and their id's: </h1>
		<?php
			viewAllCatalogs($db);
		?>
</div>