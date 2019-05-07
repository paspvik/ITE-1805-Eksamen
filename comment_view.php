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

<div class="panel panel-default">
	<div class="panel-heading">Comments</div>
	<table class="table table-striped"> 
		<thead> 
			<tr> 
				<th>#</th> 
				<th>Name</th> 
				<th>Comment</th> 
				<th>Time</th> 
				<th>Status</th> 
				<th>Operations</th> 
			</tr> 
		</thead> 
		<tbody> 
		</tbody> 
	</table>
</div>


<?php

    $servername = 'kark.uit.no';
    $username = 'stud_v19_aspvikp';
    $password = 'mariadb@uit';
    $dbname = 'stud_v19_aspvikp';

    #FJERNE MAIL FRA SKEJMA?!?!?!?!?!?!?!?!?!?!?!?!?!?!??!?????!!!! SESSION_USER ISTEDENFOR?!

    try {

        $con = new PDO("mysql:host=$servername;dbname=$dbname", $username,
        $password);

         // set the PDO error mode to exception
         $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $con->prepare('SELECT * FROM comments WHERE status=:status'); 
        $status = 'posted';
        $stmt-> bindParam(':status', $status);
        $stmt->execute();
        $all_comments = $stmt->fetchAll();

        

        #Making a for loop that iterates through the comments and prints them out
        for($r = 0; $r <= $stmt->rowcount()-1; $r++ ) {
        
            #Taking out the single comment and storing it
            $single_comment = $all_comments[$r];
            
            ?> <br>  
            
            <tr> 
            <th scope="row"><?php echo $r['comID']; ?></th> 
            <td><?php echo $single_comment['userID']; ?></td> 
            <td><?php echo $single_comment['date'] ?></td> 
            <td><?php echo $single_comment['comment'] ?></td> 
            <td><a href="editcomment.php?id=<?php echo $single_comment['comID']; ?>">Edit</a> <a href="delcomment.php?id=<?php echo $single_comment['comID']; ?>">Delete</a></td> 
            
            <td><a href="reply_comment.php?id=<?php echo $single_comment['comID']; ?>">Reply</a></td>
        
	        </tr>    
            
            <?php

            

?>
        
<?php        }


 

    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $con = null;

    ?>



    
</body>
</html>