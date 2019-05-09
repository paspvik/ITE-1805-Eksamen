<?php
/* SOURCE Comments https://codingcyber.org/simple-php-comment-system-in-php-mysql-6604/ */


#Getting the class for connecting to the sql database
include_once('../Classes/connection.php');

class Comment {

    private $db;

    #The method creates the connection to the database
    public function __construct() {
        $this->db = new Connection();
        $this->db = $this->db->dbConnect();
    }  
    
    #Function for showing comments
    public function Comment_view() {
    

        #FJERNE MAIL FRA SKEJMA?!?!?!?!?!?!?!?!?!?!?!?!?!?!??!?????!!!! SESSION_USER ISTEDENFOR?!
        $stmt = $this->db->prepare('SELECT * FROM comments WHERE status=:status'); 
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
        
        <?php }
        
    

    
    } 

    #Function for making comments
    public function New_comment() {
    
        #FJERNE MAIL FRA SKEJMA?!?!?!?!?!?!?!?!?!?!?!?!?!?!??!?????!!!! SESSION_USER ISTEDENFOR?!
        #Checking if the user has completed the form
        if(isset($_POST['name'],$_POST['email'], $_POST['comment'])) {
            $stmt = $this->db->prepare('INSERT INTO comments (comment,status) VALUES (:comment, :status)'); 
            $status = 'posted';
            $stmt-> bindParam(':comment', $_POST['comment']);
            $stmt-> bindParam(':status', $status);
            $stmt->execute();
            echo "Comment was a succsess";
            }    
    }

    #Function for replying to comments
    public function Reply_comment() {
    
        if (isset($_GET['id'])) {

            $comID = $_GET['id']; 
    
            #Selecting the comment we are going to reply to
            $stmt = $this->db->prepare('SELECT * FROM comments WHERE comID = :comID'); 
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

    #Function for editing comments
    public function Edit_comment() {
        #Checking if there is an ID in the url
        if (isset($_GET['id'])) {
            #Getting the ID from the url
            $comID = $_GET['id']; 

            #Checking if new comment is posted, if so it updates the chosen comment
            if(isset($_POST['editcomment'])) {
                $stmt = $this->db->prepare('UPDATE comments SET comment=:comment WHERE comID = :comID'); 
                $stmt-> bindParam(':comment', $_POST['editcomment']);
                $stmt-> bindParam(':comID', $comID);
                $stmt->execute();
                echo "Edit was a succsess";
                }

        } else {
            echo '<h1>Something went wrong, please try again</h1>';
            echo '<a href="../user/member.php">Go back to member page</a>';
        }

    }

    #Function for editing comments
    public function Del_comment() {
        if (isset($_GET['id'])) {
            #Getting the ID from the url
            $comID = $_GET['id']; 
        
            $stmt = $this->db->prepare('UPDATE comments SET status=:status WHERE comID = :comID'); 
            $status = 'deleted';
            $stmt-> bindParam(':status', $status);
            $stmt-> bindParam(':comID', $comID);
            $stmt->execute();
    
            echo "The comment has been removed";
    
        } else {
            echo '<h1>Something went wrong, please try again</h1>';
            echo '<a href="member.php">Go back to member page</a>';
        }
        }
}



?>