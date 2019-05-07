
<?php

/*
Sources:
https://stackoverflow.com/questions/44771540/how-to-insert-form-data-into-pdo-using-prepared-statements
https://www.youtube.com/watch?v=JaRq73y5MJk
http://www.mustbebuilt.co.uk/php/select-statements-with-pdo/
https://www.siteground.com/tutorials/php-mysql/display-table-data/
*/


require 'auth_pdo.php'; 


//Function for getting data and uploading files from form
function uploadForm($db) {

$stmt = $db->prepare("INSERT INTO file (filename, description, author, tags, data, timestamp) VALUES (:filename, :description, :author, :tags, :data, NOW())");
	$stmt->bindParam(':filename', $filename);
	$stmt->bindParam(':description', $description);
	$stmt->bindParam(':author', $author);
	$stmt->bindParam(':tags', $tags);
	$stmt->bindParam(':data', $data);


	$filename = $_FILES["file"]["name"];
	$description = $_POST["description"];
	$author = $_POST["author"];
	$tags = $_POST["tags"];
	$data = $_FILES['file']['tmp_name'];
	$timestamp = $_POST['timestamp'];
	$stmt->execute(); 

	


}

?>

<style>

table {
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  	border-collapse: collapse;
  	width: 100%;
	  }
	  
	  td, th {
		border: 1px solid #ddd;
  		padding: 8px;
	  }
	

	  tr:hover{
		background-color: #ddd;
	  }

	  th{
		padding-top: 12px;
  		padding-bottom: 12px;
 		text-align: left;
  		background-color: #32addd;
 		color: white;
	  }

}

</style>

<?php

//Function that displays all the uploaded files
function viewAllFiles($db) {

echo '<table border="1" cellspacing="" cellpadding=""> 
      <tr> 
          <th> <font face="Arial">ID</font> </td>
          <th> <font face="Arial">Filename</font> </td>  
          <th> <font face="Arial">Description</font> </td> 
          <th> <font face="Arial">Author</font> </td> 
          <th> <font face="Arial">Tags</font> </td> 
          <th> <font face="Arial">Date Created</font> </td> 
          <th> <font face="Arial">Download</font> </td> 
      </tr>';

// Echo-ing all the files in the database
$stmt = "SELECT * FROM file";

foreach($db->query($stmt) as $row){

    echo "<tr>";
    echo "<td>{$row['id']}</td>";
	echo "<td>{$row['filename']}</td>";
	echo "<td>{$row['description']}</td>";
	echo "<td>{$row['author']}</td>";
	echo "<td>{$row['tags']}</td>";
	echo "<td>{$row['timestamp']}</td>";
	echo "<td>{$row['data']}</td>";
    
    
	echo "</tr>";
}
}





//When selecting a catalog pulls out data from the desired accesslevel
global $view;
function viewByAccess($db,$level) {

	echo '<table border="1" cellspacing="" cellpadding=""> 
		  <tr> 
			  <th> <font face="Arial">ID</font> </td>
			  <th> <font face="Arial">Filename</font> </td>  
			  <th> <font face="Arial">Description</font> </td> 
			  <th> <font face="Arial">Author</font> </td> 
			  <th> <font face="Arial">Tags</font> </td> 
			  <th> <font face="Arial">Date Created</font> </td> 
			  <th> <font face="Arial">Download</font> </td> 
		  </tr>';
	
	// Echo-ing all the files in the database
	$stmt = "SELECT * FROM file where access_level = $level";
	
	foreach($db->query($stmt) as $row){
	
		echo "<tr>";
		echo '<td>' . '<a href="' . 'singlepage.php?view='. $row['id'] . '">' .  "{$row['id']}" . '</a>'. '</td>';
		echo "<td>{$row['filename']}</td>";
		echo "<td>{$row['description']}</td>";
		echo "<td>{$row['author']}</td>";
		echo "<td>{$row['tags']}</td>";
		echo "<td>{$row['timestamp']}</td>";
		echo "<td>{$row['data']}</td>";
		echo "</tr>";


		

	}
	
	}



	//Function for opening a single file
	function AccessSingleFile($db,$view) {

		echo '<table border="1" cellspacing="" cellpadding=""> 
			  <tr> 
				  <th> <font face="Arial">ID</font> </td>
				  <th> <font face="Arial">Filename</font> </td>  
				  <th> <font face="Arial">Description</font> </td> 
				  <th> <font face="Arial">Author</font> </td> 
				  <th> <font face="Arial">Tags</font> </td> 
				  <th> <font face="Arial">Date Created</font> </td> 
				  <th> <font face="Arial">Download</font> </td> 
			  </tr>';
		
		// Echo-ing all the files in the database¨

		
		$stmt = "SELECT * FROM file where id = $view";
		
		foreach($db->query($stmt) as $row){
		
			echo "<tr>";
			echo '<td>' . '<a href="' . 'catalog.php?view='. $row['id'] . '">' .  "{$row['id']}" . '</a>'. '</td>';
			echo "<td>{$row['filename']}</td>";
			echo "<td>{$row['description']}</td>";
			echo "<td>{$row['author']}</td>";
			echo "<td>{$row['tags']}</td>";
			echo "<td>{$row['timestamp']}</td>";
			echo "<td>{$row['data']}</td>";
			
			
			echo "</tr>";

		}
		}





//Function for deleting files
function deleteFile($db,$id){
    $stmt = "DELETE FROM file where id = $id";
    $result = $db->prepare($stmt);
    $result->execute();
}



//Creates new catalogs
function catalogCreator($db) {
	$stmt = $db->prepare("INSERT INTO catalog (cat_name) VALUES (:cat_name)");
	$stmt->bindParam(':cat_name', $cat_name);
	$cat_name = $_POST["cat_name"];
	$stmt->execute(); 



}


function viewAllCatalogs($db) {

		echo '<table border="1" cellspacing="" cellpadding=""> 
			  <tr> 
				  <th> <font face="Arial">Catalog ID</font> </td>
				  <th> <font face="Arial">Catalog Name</font> </td>  
			  </tr>';
		
		// Echo-ing all the files in the database
		$stmt = "SELECT * FROM catalog";
		
		foreach($db->query($stmt) as $row){
			echo "<tr>";
			echo "<td>{$row['cat_id']}</td>";
			echo "<td>{$row['cat_name']}</td>";
			echo "</tr>";
		}
}
		





?>
