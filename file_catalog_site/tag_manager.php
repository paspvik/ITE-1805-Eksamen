


<?php
require '../Classes/tag.php';
$tag = new Tag();
?>


<h1> Create a new tag </h1>
<form action="tag_manager.php" method="post" enctype="multipart/form-data">
		Tag Name: <input type="text" name="new_tag"><br>
		<button type="submit" name="btn_submit" value="new_tag"> Create </button>
	</form>	

    <br>





<h1> Add tags to file </h1>
    <form action="tag_manager.php" method="post" enctype="multipart/form-data">
         <label>Tags:</label>
            <select name="tag_name">
            <?php 
                $tag->viewTagNames();
            ?>  
            </select>
            <label>Filename:</label>
            <select name="file_name">
            <?php
                $tag->viewFileNames();
            ?>  
            </select>
            <button type="submit" name="btn_submit" value= "add_tag"> Create </button>
            </form>


<?php
    if($_REQUEST['btn_submit']=="new_tag"){
        $tag->createTag();
    }
    else if($_REQUEST['btn_submit']=="add_tag"){
        $tag->addTag();
    }
?>

