<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Project ITE1805</title>
</head>
<body>

<?php

try {
    $servername = 'kark.uit.no';
    $username = 'stud_v19_aspvikp';
    $password = 'mariadb@uit';
    $dbname = 'stud_v19_aspvikp';

    $con = new PDO("mysql:host=$servername;dbname=$dbname", $username,
    $password);

     // set the PDO error mode to exception
     $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    
     if (isset($_GET['id'])) {

        $comID = $_GET['id']; 

        #Selecting the comment we are going to reply to
        $stmt = $con->prepare('SELECT * FROM comments WHERE comID = :comID'); 
        $stmt-> bindParam(':comID', $comID);
        $stmt->execute();
        $all_comments = $stmt->fetchAll();
        

        #Making a for loop that iterates through the comments and prints them out
        for($r = 0; $r <= $stmt->rowcount()-1; $r++ ) {
        
            #Taking out the single comment and storing it
            $single_comment = $all_comments[$r];
            
            ?> <br>  
            <tr> <h3>Comment:</h3>
            <th scope="row"><?php echo $r['comID']; ?></th> 
            <td><?php echo $single_comment['userID']; ?></td> 
            <td><?php echo $single_comment['date'] ?></td> 
            <td><?php echo $single_comment['comment'] ?></td> 
 

            </tr>    

            <div class="commentedit">

            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >


            <div class="panel panel-default">
            <div class="panel-heading">Replies:</div>
            <div class="panel-heading">Her skal vi printe replies</div>

            <div class="panel-body">
                <form method="post">
                <div class="form-group">
                        <label for="InputReply">Reply</label>
                        <textarea name="reply" class="form-control" rows="3"></textarea>
                    </div>
                <button type="submit" class="btn btn-primary">Post</button>
                </form>
            </div>
            </div>
            </div>       



 
<?php        }

            #INSERT INTO replies (:reply, comID) VALUES (:reply,:comID)')

        if(isset($_POST['reply'])) {
            $stmt = $con->prepare('INSERT INTO replies SET reply = :reply, comID = :comID'); 
            $stmt-> bindParam(':reply', $_POST['reply']);
            $stmt-> bindParam(':comID', $comID);
            $stmt->execute();
            echo "Reply was a succsess";
            }

        } else {
            echo 'error please go back to member';
        }


        



}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$con = null;




?>










    
</body>
</html>