


<?php
/*
Sources:
1. https://www.youtube.com/watch?v=a_PYf-6Ze40
2. https://phpdelusions.net/pdo_examples/select
3. https://stackoverflow.com/questions/14071250/how-to-place-two-forms-on-the-same-page
*/

require 'connection.php';




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

    //Displays all of the catalogs in a table
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

    //Gets catalogs names to use in selection menu
    public function viewCatalogs() {
        $get_catalogs = "SELECT cat_name FROM catalog";
        
        foreach($this->db->query($get_catalogs) as $row) {
            echo "<option>". $row['cat_name']. "</option>";
        }
    }
    //Gets catalogs id's to use in selection menu
    public function viewCatalogID() {
        $get_catalog_id = "SELECT cat_id FROM catalog";
        
        foreach($this->db->query($get_catalog_id) as $row) {
            echo "<option>". $row['cat_id']. "</option>";
        }
    }

    //Deletes the selected catalog
    public function deleteCatalog(){
        $cat_name = $_POST['cat_name']; // Gets filename from selectionmenu
        $get_cat_id = "SELECT cat_id FROM catalog WHERE cat_name = '$cat_name'" ; 
        $cat_id = $this->db->query("$get_cat_id")->fetch();
        $cat_id = (int)$cat_id[0];

        $stmt = "DELETE FROM catalog WHERE cat_id = $cat_id";
        $this->db->query("$stmt"); // Prepare
        


    }

    //Changes the ID of an catalog
    public function changeCatalogID(){

        $cat_name = $_POST['cat_name']; // Gets filename from selectionmenu
        $new_id  = $_POST['new_id']; // Gets tagname from selectionmenu

        $new_id = (int)$new_id;

        
        $stmt = "UPDATE catalog SET cat_id = $new_id where cat_name = '$cat_name'"; // Prepare
        $this->db->query("$stmt");
 

    }
            

}	
?>




