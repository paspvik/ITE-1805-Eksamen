

<?php
	require '../Classes/catalog.php'; 
    $catalog = new Catalog();
    require '../Classes/file.php';
    session_start();
    $new_file = new File();
    $access_level = $new_file->get_access_level();
    error_reporting(0);
?>

<?php if ($access_level >= 3) {  ?>

<h1> Create catalogs</h1>

<html>
	<body>
	<form action="catalog_creator.php" method="post" enctype="multipart/form-data">
		Catalog Name: <input type="text" name="cat_name"><br>
		<button type="submit" name="btn_submit" value= "create_catalog"> Create </button>
	</form>
	</body>
</html>
</div>




<h1> Delete Catalog </h1>
    <form action="catalog_creator.php" method="post" enctype="multipart/form-data">
         <label>Tags:</label>
            <label>Catalog Name:</label>
            <select name="cat_name"> 
            <?php
			   $catalog->viewCatalogs();
            ?>  
            </select>
            <button type="submit" name="btn_submit" value= "remove_catalog"> Delete </button>
            </form>





<h1> Change access level for catalog</h1>
    <form action="catalog_creator.php" method="post" enctype="multipart/form-data">
         <label>Catalog Name:</label>
            <select name="cat_name">
            <?php 
                $catalog->viewCatalogs();
            ?>  
            </select>
			New ID: <input type="number" name="new_id">
            </select>
            <button type="submit" name="btn_submit" value= "change_id"> Change ID </button>
            </form>



<?php
    if($_REQUEST['btn_submit']=="create_catalog"){
		$catalog->catalogCreator();
    }
    else if($_REQUEST['btn_submit']=="remove_catalog"){
        $catalog->deleteCatalog();
	}
	else if($_REQUEST['btn_submit']=="change_id"){
        $catalog->changeCatalogID();
	}
?>


<div>
	<h1> All the of the catalogs and their id's: </h1>
		<?php
			$catalog->viewAllCatalogs();
		?>
</div>

<?php } ?>