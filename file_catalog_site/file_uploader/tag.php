

<?php
#https://www.youtube.com/watch?v=a_PYf-6Ze40
#https://phpdelusions.net/pdo_examples/select
#https://stackoverflow.com/questions/14071250/how-to-place-two-forms-on-the-same-page

require 'file_uploader/connection.php';

class Tag {
	private $db;
	

	
    public function __construct() {
        $this->db = new Connection();
        $this->db = $this->db->dbConnect();
    }


    public function createTag() {
        $stmt = $this->db->prepare("INSERT INTO tags (tag_name) VALUES (:new_tag)");
        $stmt->bindParam(':new_tag', $new_tag);
        $new_tag = $_POST['new_tag'];
        $stmt->execute(); 
        
    }



    public function viewTagNames() {
        $get_tags = "SELECT tag_name FROM tags";
        
        foreach($this->db->query($get_tags) as $row) {
            echo "<option>". $row['tag_name']. "</option>";
        }
    }



    public function viewFileNames() {
        $get_files = $stmt = "SELECT filename FROM file";

        foreach($this->db->query($get_files) as $row) {
            echo "<option>". $row['filename']. "</option>";
        }
    }



    public function addTag() {
        
        $file_name = $_POST['file_name']; // Gets filename from selectionmenu
        $tag_name  = $_POST['tag_name']; // Gets tagname from selectionmenu

    
        $get_tag_id = "SELECT tag_id FROM tags WHERE tag_name = '$tag_name'" ;  //bind
        $get_file_id = "SELECT file_id FROM file WHERE filename = '$file_name'" ; //bind
        
        $stmt = $this->db->prepare("INSERT INTO file_tag_id (file_id, tag_id) VALUES (:file_id, :tag_id)");
        
        $tag_id = $this->db->query("$get_tag_id")->fetch();
        $file_id = $this->db->query("$get_file_id")->fetch();

        $tag_id = (int)$tag_id[0];      // Typecast from string to int and pulls out the first element of the array
        $file_id = (int)$file_id[0];
        
        $stmt->bindParam(':file_id', $file_id);
        $stmt->bindParam(':tag_id', $tag_id);

        $stmt->execute(); 
        
        
    }
    
}
?>