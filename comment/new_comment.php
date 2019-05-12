<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Project ITE1805</title>
</head>
<body>


<!-- SOURCE Commentbox https://codingcyber.org/simple-php-comment-system-in-php-mysql-6604/ -->

<div class="comment">
            <br>
            <br>
            <br>
            <br>
            <br>
            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

            <div class="panel panel-default">
            <div class="panel-heading">Comments</div>
            <div class="panel-body">
                <form method="post">
                    <div class="form-group">
                        <label for="Logged_in_as">You are logged in as:</label>
                    </div>
                        <div class="form-group">
                        <label for="session_user"><?php session_start(); 
                        if(isset($_SESSION["username"])) {
                        echo $_SESSION["username"]; 
                        }else {
                            echo "No user is logged in";
                            }
                        ?></label>
                   </div>
                   <div class="form-group">
                        <label for="InputComment">Comment</label>
                        <textarea name="comment" class="form-control" rows="3" required></textarea>
                    </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            </div>
   </div>


   <?php
     #Including the class
    include_once('../Classes/comment.php');

    #Initializing the comment view
    $object = new Comment();
    $object->Comment_view();
    $object->New_comment();
    
    ?>

   





</body>
</html>