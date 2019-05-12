


<?php


/*
Sources:
https://stackoverflow.com/questions/44771540/how-to-insert-form-data-into-pdo-using-prepared-statements
https://www.youtube.com/watch?v=JaRq73y5MJk
http://www.mustbebuilt.co.uk/php/select-statements-with-pdo/
https://www.siteground.com/tutorials/php-mysql/display-table-data/
https://stackoverflow.com/questions/8662535/trigger-php-function-by-clicking-html-link
https://www.w3schools.com/w3css/w3css_tables.asp
https://stackoverflow.com/questions/16222097/mysql-left-join-3-tables
*/

require 'file_uploader/connection.php';




global $view;

class File {
	private $db;
	

	
    public function __construct() {
        $this->db = new Connection();
        $this->db = $this->db->dbConnect();
    }


    public function uploadForm() {

        $stmt = $this->db->prepare("INSERT INTO file (filename, description, author, data, timestamp) VALUES (:filename, :description, :author, :data, NOW())");
        $stmt->bindParam(':filename', $filename);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':data', $data);
    
    
        $filename = $_FILES["file"]["name"];
        $description = $_POST["description"];
        $author = $_POST["author"];

        $data = $_FILES['file']['tmp_name'];
        $timestamp = $_POST['timestamp'];
        $stmt->execute(); 
        }

	
	public function createLinks($level){
		$stmt = "SELECT * FROM catalog ";

		#Gets all the catalog levels and creates a link that when clicked passes the access level to viewByAccess to display the files associated with that level
		foreach($this->db->query($stmt) as $row){
    	echo "</br>";
   		echo  '<a href="' . 'catalog.php?level='. $row['cat_id'] . '">' .  "<td>{$row['cat_name']}</td>" . '</a>'; #Creates a link with the cat_id and stores the url variable.
		echo "</br>";
				}	
		}



		//Getting the tags from the tags table by looking up the relevant tags in file_tag_id by file_id and putting it into a function so i can get the file_id from the foreach loop	  
		function tagHandler($file_id){

		$get_tags = "SELECT tags.tag_name from tags  
					LEFT JOIN  file_tag_id ON tags.tag_id  = file_tag_id.tag_id
					LEFT JOIN file ON file.file_id = file_tag_id.file_id
					WHERE file.file_id = $file_id;
					;" ;
				
				$tags = $this->db->query("$get_tags")->fetchAll();

				//The output of tags becomes an nested array which we need to iterate through
				echo '<br>';
				foreach($tags as $tag ){
				return $tags[0][0].', '. $tags[1][0]. ', ' . $tags[2][0]. ', ' . $tags[3][0]. ', ' . $tags[4][0] ;
				}
			}


		//When selecting a catalog pulls out data from the desired accesslevel
		public function viewByAccess($level) {


		// Echo-ing all the files and their data from database
		$stmt = "SELECT * FROM file where access_level = $level";
		$fil_id = "SELECT file_id FROM file";
		
	
		foreach($this->db->query($stmt) as $row){
			//Create an variable to put inside of the echo to avoid escapes
			$tags = $this->tagHandler($row['file_id']); 
			echo
			'<tr>'.
			'<td>'. '<a href="singlepage.php?view='. $row['file_id'] . '">' .$row['file_id'] . '</a>'. '</td>'.
			'<td>'. $row['filename']. '</td>'. 
			'<td>'. $row['description']. '</td>'. 
			'<td>'. $row['author']. '</td>'. 
			'<td>'. $tags . '</td>'. 
			'<td>'. $row['timestamp']. '</td>'.
			'<td>'. $row['data']. '</td>'. 
			'</tr>';
			

		}
		}    



        
		//Function for opening a single file
		public function accessSingleFile($view) {
		
			// Echo-ing all the files in the database
			$stmt = "SELECT * FROM file where file_id = $view";

			foreach($this->db->query($stmt) as $row) {
				
				echo
				'<tr>'.
				'<td>'. $row['file_id']. '</td>'. 
				'<td>'. $row['filename']. '</td>'. 
				'<td>'. $row['description']. '</td>'. 
				'<td>'. $row['author']. '</td>'. 
				'<td>'. $row['tags']. '</td>'. 
				'<td>'. $row['timestamp']. '</td>'.
				'<td>'. $row['data']. '</td>'. 
				'</tr>';
			}
		}






		//Function for deleting files
		public function deleteFile($id){
			$stmt = "DELETE FROM file where file_id = $id";
			$result = $this->db->prepare($stmt);
			$result->execute();
		}


				


			}


?>