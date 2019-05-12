<?php
/* SOURCE replies https://codingcyber.org/simple-php-comment-system-in-php-mysql-6604/ */
/* SOURCE Comment-/replybox structure https://fribly.com/2014/10/29/pure-css-comments-box/ */

#Getting the class for connecting to the sql database
include_once('../Classes/connection.php');

class Reply {

    private $db;

    #The method creates the connection to the database
    public function __construct() {
        $this->db = new Connection();
        $this->db = $this->db->dbConnect();
        
        session_start();
        #IF user is not logged in, then they will be sendt to the login page
        if(!isset($_SESSION["username"])) {
            header("location: ../user/login.php");
            }
    }  
    
    #Function for showing replies
    public function reply_view() {


        if (isset($_GET['id'])) {

            #Saving the comment ID
            $comID = $_GET['id']; 

            #Fetching all the replies
            $stmt = $this->db->prepare('SELECT * FROM replies where comID =:comID'); 
            $stmt-> bindParam(':comID', $comID);
            $stmt->execute();
            $all_replies = $stmt->fetchAll();
    
            #Making a for loop that iterates through the replies and prints them out
            for($r = 0; $r <= $stmt->rowcount()-1; $r++ ) {
            
                #Taking out the single replies and storing it
                $single_comment = $all_replies[$r];

                #Fetching the userID of the owner of the reply
                $statement = $this->db->prepare('SELECT * FROM comments WHERE comID=:comID'); 
                $statement-> bindParam(':comID', $comID);
                $statement->execute();
                $all_comments = $statement->fetchAll();
                $one_comment = $all_comments[0];
                $userID = $one_comment["userID"];
            
                #Midlertidig løsning!!!!!!!!!!!!
                $username = $single_comment["username"];
                
                $repID = $single_comment['RepID'];

                #Fetching the access_level
                #Dont have time to fix this issue
                error_reporting(0);
                require '../Classes/file.php';
                $new_file = new File();
                $access_level = $new_file->get_access_level();
                
                ?> <br>  
    
                <link href="../reply/reply_view_style.css" rel="stylesheet" type="text/css"> <!-- Source for css -->
    
                <!-- Main container -->
                <div class="comments-container">
                        <ul id="comments-list" class="comments-list">
                            <li>
                                <div class="comment-main-level">
                                    <!-- Comment container-->
                                    <div class="comment-box">
                                        <div class="comment-head">
                                            <h6 class="comment-name by-author"><h6>User: <?php echo $username; ?></h6> 
                                            <span><?php echo $single_comment['date'] ?></span>
                                        </div>
                                        <div class="comment-content">
                                        <?php echo $single_comment['reply'] ?>
                                        <?php if ($access_level >= 3) { ?>
                                        <a href="../moderator/editreply.php?id=<?php echo $repID; ?>">Edit  </a> <a href="../moderator/delreply.php?id=<?php echo $repID; ?>">Delete </a>
                                        <?php } ?>
                                        </div>
                                    </div>
                                </div>
    
                    </div>
                    
            <?php } 

            
            
        
        } else {
            echo "Something went wrong, please try again";
        }
            
        
    
        
    } 

    #Function for replying to a comment
    public function Reply_comment() {
    
            if (isset($_GET['id'])) {
    
                $comID = $_GET['id']; 
        
                #Selecting the comment we are going to reply to from all comments
                $stmt = $this->db->prepare('SELECT * FROM comments WHERE comID = :comID'); 
                $stmt-> bindParam(':comID', $comID);
                $stmt->execute();
                $all_comments = $stmt->fetchAll();

                #Finding the user that made the comment
                $comment_user = $all_comments[0];
                $comment_user_id = $comment_user["userID"];


                #Selecting the username of the user that made the comment
                $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :userID'); 
                $stmt-> bindParam(':userID', $comment_user_id);
                $stmt->execute();
                $user_that_commented = $stmt->fetchAll();
                $user_array = $user_that_commented[0];
                #Username of user that commented
                $username_commentuser = $user_array["username"];

                #Making a for loop that iterates through the comments and prints them out
                for($r = 0; $r <= $stmt->rowcount()-1; $r++ ) {
                
                    #Taking out the single comment and storing it
                    $single_comment = $all_comments[$r];
                    $username = $_SESSION["username"];
                    
                    ?> <br>  
                    <div class="form-group">
                    <tr> <h4>Comment:</h4>
                            <td>From user:<?php echo ' '. $username_commentuser . '<br>'; ?></td> 
                            <td><?php echo $single_comment['date'] ?></td> 
                            <td><?php echo $single_comment['comment'] ?></td> 
                            <br>
                            <br>
                            <?php echo 'You are replying as: '. $username ?>
                            <br> 
                            <br>
                            
                        </div> 
        
                    <div class="commentedit">
        
                    <!-- Latest compiled and minified CSS -->
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
        
                    <div class="panel panel-default">
    
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
        

                #Midlertidig løsning
                $username = $_SESSION["username"];
                    
        
                if(isset($_POST['reply'])) {
                    $stmt = $this->db->prepare('INSERT INTO replies SET reply = :reply, comID = :comID, username = :username'); 
                    $stmt-> bindParam(':reply', $_POST['reply']);
                    $stmt-> bindParam(':comID', $comID);
                    $stmt-> bindParam(':username', $username);
                    $stmt->execute();
                    echo "Reply was a succsess";
                    }
        
                } else {
                    echo 'error please go back to member';
                }
        
        
                
    }

    #Function for editing replies
    public function Edit_reply() {
        if (isset($_GET['id'])) {
            #Getting the ID from the url
            $repID = $_GET['id']; 

            #Checking if new comment is posted, if so it updates the chosen comment
            if(isset($_POST['editreply'])) {
                $stmt = $this->db->prepare('UPDATE replies SET reply=:reply WHERE RepID = :repID'); 
                $stmt-> bindParam(':reply', $_POST['editreply']);
                $stmt-> bindParam(':repID', $repID);
                $stmt->execute();
                echo "Edit was a succsess";
                }

        } else {
            echo '<h1>Something went wrong, please try again</h1>';
            echo '<a href="../user/member.php">Go back to member page</a>';
        }

    


    }   
    
    #Function for deleting replies 
    public function Del_reply() {
        if (isset($_GET['id'])) {
            #Getting the ID from the url
            $repID = $_GET['id']; 

            #Saving the reply
            $statement = $this->db->prepare('SELECT * FROM replies WHERE RepID =:repID'); 
            $statement-> bindParam(':repID', $repID);
            $statement->execute();
            $reply =  $statement->fetchAll();
            $single_reply = $reply[0];
            $comID = $single_reply["comID"];
            $reply = $single_reply["reply"];
            $date = $single_reply["date"];
            $username = $single_reply["username"];

        
            #Inserting the reply into the "deleted" table
            $query = $this->db->prepare('INSERT INTO deleted_replies SET RepID = :repid, comID = :comID, reply = :reply, Deleted = :date '); 
            $query-> bindParam(':repid', $repID);
            $query-> bindParam(':comID', $comID);
            $query-> bindParam(':reply', $reply);
            $query-> bindParam(':date', $date);
            $query->execute();
            echo '<a href="../user/member.php">Comment delete, click here to go to member page</a>';


            #Deleting the reply from the original table
            $stmt = $this->db->prepare('DELETE FROM replies WHERE RepID = :repID;'); 
            $stmt-> bindParam(':repID', $repID);
            $stmt->execute();


        } else {
            echo '<h1>Something went wrong, please try again</h1>';
            echo '<a href="../user/member.php">Go back to member page</a>';
        }



    }    
   

}





?>