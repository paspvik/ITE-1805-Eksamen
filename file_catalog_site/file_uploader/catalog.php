


<?php
require 'file_uploader/connection.php';




class Catalog {
	private $db;
	

	
    public function __construct() {
        $this->db = new Connection();
        $this->db = $this->db->dbConnect();
    }

    //Creates new catalogs
    public function catalogCreator() {
        $stmt = $this->db->prepare("INSERT INTO catalog (cat_name) VALUES (:cat_name)");
        $stmt->bindParam(':cat_name', $cat_name);
        $cat_name = $_POST["cat_name"];
        $stmt->execute(); 
    }


    public function viewAllCatalogs() {

            echo '<table border="1" cellspacing="" cellpadding=""> 
                <tr> 
                    <th> <font face="Arial">Catalog ID</font> </td>
                    <th> <font face="Arial">Catalog Name</font> </td>  
                </tr>';
            
            // Echo-ing all the files in the database
            $stmt = "SELECT * FROM catalog";
            
            foreach($this->db->query($stmt) as $row){
                echo "<tr>";
                echo "<td>{$row['cat_id']}</td>";
                echo "<td>{$row['cat_name']}</td>";
                echo "</tr>";
            }
    }
            

}	
?>




