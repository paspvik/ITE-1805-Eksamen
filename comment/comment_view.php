<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Project ITE1805</title>
</head>
<body>

<!-- SOURCE View Comments https://codingcyber.org/simple-php-comment-system-in-php-mysql-6604/ -->


<?php
 #Including the class
include_once('../Classes/comment.php');

#Starting user sesssion
session_start();


 #Initializing the comment view
 $object = new Comment();
 $object->Comment_view();


?>



    
</body>
</html>