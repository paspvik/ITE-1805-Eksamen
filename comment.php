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

            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

            <div class="panel panel-default">
            <div class="panel-heading">Comments</div>
            <div class="panel-body">
                <form method="post">
                    <div class="form-group">
                        <label for="InputName">test</label>
                        <input type="text" name="name" class="form-control" id="InputMail" placeholder="Name" required>
                    </div>
                        <div class="form-group">
                        <label for="InputMail">test</label>
                        <input type="text" name="email" class="form-control" id="InputMail" placeholder="Email" required>
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

         

         #Checking if the user has completed the form
         if(isset($_POST['name'],$_POST['email'], $_POST['comment'])) {
            $stmt = $con->prepare('INSERT INTO comments (comment,status) VALUES (:comment, :status)'); 
            $status = 'posted';
            $stmt-> bindParam(':comment', $_POST['comment']);
            $stmt-> bindParam(':status', $status);
            $stmt->execute();
            echo "Comment was a succsess";
            }

    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $con = null;

    ?>

   





</body>
</html>