


<?php
require '../Classes/tag.php';
$tag = new Tag();
?>


<h1> Create a new tag </h1>
<form action="tag_manager.php" method="post" enctype="multipart/form-data">
        <label>Tag Name: </label>
        <input type="text" name="new_tag">
		<button type="submit" name="btn_submit" value="new_tag"> Create </button>
	</form>	
    <br>


<h1> Delete tag </h1>
<form action="tag_manager.php" method="post" enctype="multipart/form-data">
            <label>Select Tag:</label>
            <select name="tag_name"> 
            <?php
			   $tag->viewTagNames();
            ?>  
            </select>
            <button type="submit" name="btn_submit" value= "delete_tag"> Delete </button>
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
            <br>


<h1> All the tags </h1>
<?php $tag->viewAllTags(); ?>

<?php
    if($_REQUEST['btn_submit']=="new_tag"){
        $tag->createTag();
    }
    else if($_REQUEST['btn_submit']=="add_tag"){
        $tag->addTag();
    }
    else if($_REQUEST['btn_submit']=="delete_tag"){
        $tag->deleteTag();
    }
?>

