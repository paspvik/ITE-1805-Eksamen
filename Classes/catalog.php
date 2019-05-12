


<?php
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


    public function viewCatalogs() {
        $get_catalogs = "SELECT cat_name FROM catalog";
        
        foreach($this->db->query($get_catalogs) as $row) {
            echo "<option>". $row['cat_name']. "</option>";
        }
    }

    public function viewCatalogID() {
        $get_catalog_id = "SELECT cat_id FROM catalog";
        
        foreach($this->db->query($get_catalog_id) as $row) {
            echo "<option>". $row['cat_id']. "</option>";
        }
    }


    public function deleteCatalog(){
        $cat_name = $_POST['cat_name']; // Gets filename from selectionmenu
        $get_cat_id = "SELECT cat_id FROM catalog WHERE cat_name = '$cat_name'" ; 
        $cat_id = $this->db->query("$get_cat_id")->fetch();
        $cat_id = (int)$cat_id[0];

        $stmt = "DELETE FROM catalog WHERE cat_id = $cat_id";
        $this->db->query("$stmt"); // Prepare
        


    }


    public function changeCatalogID(){

        $cat_name = $_POST['cat_name']; // Gets filename from selectionmenu
        $new_id  = $_POST['new_id']; // Gets tagname from selectionmenu

        $new_id = (int)$new_id;

        
        $stmt = "UPDATE catalog SET cat_id = $new_id where cat_name = '$cat_name'"; // Prepare
        $this->db->query("$stmt");
 

    }
            

}	
?>




