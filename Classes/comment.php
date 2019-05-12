<?php
/* SOURCE Comments https://codingcyber.org/simple-php-comment-system-in-php-mysql-6604/ */
/* SOURCE Comment-/replybox structure https://fribly.com/2014/10/29/pure-css-comments-box/ */

#Getting the class for connecting to the sql database
include_once('../Classes/connection.php');

class Comment {

    private $db;

    #The method creates the connection to the database
    public function __construct() {
        $this->db = new Connection();
        $this->db = $this->db->dbConnect();

        #IF user is not logged in, then they will be sendt to the login page
        if(!isset($_SESSION["username"])) {
            header("location: ../user/login.php");
        }

    }  
    
    #Function for showing comments
    public function Comment_view() {

        #Fetching the comments
        $docno = $_GET['view'];
        $stmt = $this->db->prepare('SELECT * FROM comments where docno =:docno'); 
        $stmt-> bindParam(':docno', $docno);
        $stmt->execute();
        $all_comments = $stmt->fetchAll();


        #Making a for loop that iterates through the comments and prints them out
        for($r = 0; $r <= $stmt->rowcount()-1; $r++ ) {
        
            #Taking out the single comment and storing it
            $single_comment = $all_comments[$r];

            #Selecting the userID from the comment
            $comment_user_id = $single_comment["userID"];

            #Selecting the username of the user that made the comment
            $query = $this->db->prepare('SELECT * FROM users WHERE id = :userID'); 
            $query-> bindParam(':userID', $comment_user_id);
            $query->execute();
            $user_that_commented = $query->fetchAll();
            $user_array = $user_that_commented[0];
            #Username of user that commented
            $username_commentuser = $user_array["username"];

            #Fetching the access_level
            $new_file = new File();
            $access_level = $new_file->get_access_level();
            
            ?> <br>  

            <link href="../comment/comment_view_style.css" rel="stylesheet" type="text/css"> <!-- Source for css -->

            <!-- Main container -->
            <div class="comments-container">
                    <ul id="comments-list" class="comments-list">
                        <li>
                            <div class="comment-main-level">
                                <!-- Comment container-->
                                <div class="comment-box">
                                    <div class="comment-head">
                                        <h6 class="comment-name by-author"><h6>
                                            User:<?php echo ' '. $username_commentuser; ?>
                                        </h6> 
                                        <span><?php echo $single_comment['date'] ?></span>
                                    </div>
                                    <div class="comment-content">
                                    
                                    <?php echo $single_comment['comment'] ?>
   
                                    <?php if ($access_level >= 3) { ?>
                                    <a href="../moderator/editcomment.php?id=<?php echo $single_comment['comID']; ?>">Edit  </a> <a href="../moderator/delcomment.php?id=<?php echo $single_comment['comID']; ?>">Delete </a>
                                    <a href="../reply/reply_comment.php?id=<?php echo $single_comment['comID']; ?>">Reply</a>
                                    <?php } else { ?>
                                        <a href="../reply/reply_comment.php?id=<?php echo $single_comment['comID']; ?>">Reply</a>
                                    <?php  } ?>
                                    </div>
                                </div>
                            </div>

                </div>
                
         <?php 
         
        }
        
    

    
    } 
    
    #Function for making comments
    public function New_comment() {

        #Fetching the userID of the session user
        $username =  $_SESSION["username"];
        $stmt = $this->db->prepare('SELECT * FROM users WHERE username=:username'); 
        $stmt-> bindParam(':username', $username);
        $stmt->execute();
        $all_user = $stmt->fetchAll();
        $user_array = $all_user[0];
        $user_id = $user_array["id"];


        #Checking if the user has completed the form
        if(isset($_POST['comment'])) {
            $docno = $_GET['view'];
            $stmt = $this->db->prepare('INSERT INTO comments (comment,userID,docno) VALUES (:comment,:userID,:docno)'); 
            $stmt-> bindParam(':comment', $_POST['comment']);
            $stmt-> bindParam(':userID', $user_id);
            $stmt-> bindParam(':docno', $docno);
            $stmt->execute();
            echo '<script>alert("The posting of the comment was a succsess, please refresh the page to see your");</script>'; 

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

            #Saving the comment
            $statement = $this->db->prepare('SELECT * FROM comments WHERE comID =:comID'); 
            $statement-> bindParam(':comID', $comID);
            $statement->execute();
            $comment =  $statement->fetchAll();
            $single_comment = $comment[0];
            $comID = $single_comment["comID"];
            $userID = $single_comment["userID"];
            $date = $single_comment["date"];
            $comment = $single_comment["comment"];

        
            #Inserting the reply into the "deleted" table
            $query = $this->db->prepare('INSERT INTO deleted_comments SET comID = :comID, userID = :userID, date = :date, comment = :comment'); 
            $query-> bindParam(':comID', $comID);
            $query-> bindParam(':userID', $userID);
            $query-> bindParam(':date', $date);
            $query-> bindParam(':comment', $comment);
            $query->execute();
            echo '<a href="../user/member.php?level=2">Comment deleted, click here to go to member page</a>';


            #Deleting the comment from the original table
            $stmt = $this->db->prepare('DELETE FROM comments WHERE comID = :comID;'); 
            $stmt-> bindParam(':comID', $comID);
            $stmt->execute();


        } else {
            echo '<h1>Something went wrong, please try again</h1>';
            echo '<a href="../user/member.php">Go back to member page</a>';
        }



    
    
    }
}



?>