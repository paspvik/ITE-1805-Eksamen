<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ITE1805</title>
</head>
<body>

<!-- SOURCE Commentbox https://codingcyber.org/simple-php-comment-system-in-php-mysql-6604/ -->

<div class="commentedit">

            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

            <div class="panel panel-default">
            <div class="panel-heading">Edit comment</div>
            <div class="panel-body">
                <form method="post">
                   <div class="form-group">
                        <label for="InputComment">Comment</label>
                        <textarea name="editcomment" class="form-control" rows="3"></textarea>
                    </div>
                <button type="submit" class="btn btn-primary">Edit</button>
                </form>
            </div>
            </div>
   </div>

<?php

 #Including the class
 include_once('../Classes/comment.php');

 #Initializing the edit comment method
 $object = new Comment();
 $object->Edit_comment();



?>


</body>
</html>