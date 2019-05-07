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

$servername = 'kark.uit.no';
$username = 'stud_v19_aspvikp';
$password = 'mariadb@uit';
$dbname = 'stud_v19_aspvikp';


try{

    #Checking if there is an ID in the url
    if (isset($_GET['id'])) {
        #Getting the ID from the url
        $comID = $_GET['id']; 

        $con = new PDO("mysql:host=$servername;dbname=$dbname", $username,
        $password);

        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        #Checking if new comment is posted, if so it updates the chosen comment
        if(isset($_POST['editcomment'])) {
            $stmt = $con->prepare('UPDATE comments SET comment=:comment WHERE comID = :comID'); 
            $stmt-> bindParam(':comment', $_POST['editcomment']);
            $stmt-> bindParam(':comID', $comID);
            $stmt->execute();
            echo "Edit was a succsess";
            }
        




    } else {
        echo '<h1>Something went wrong, please try again</h1>';
        echo '<a href="member.php">Go back to member page</a>';
    }

}


catch(PDOException $e)
{
    echo "Error: " . $e->getMessage();
}
$con = null;

?>


</body>
</html>