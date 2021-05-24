<?php
    require_once("DBConn.php");

    class commentDataHandler{

        public function getComments($post_id){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "SELECT * FROM comment WHERE post_id='$post_id'";

            $result = mysqli_query($conn,$query);

            $num_rows = mysqli_num_rows($result);

            $arr = array();

            for($i=0;$i<$num_rows;$i++){
                $row = mysqli_fetch_assoc($result);
                $user_id = $row["user_id"];
                
                $query = "SELECT user_name FROM user WHERE user_id='$user_id'";

                $result2 = mysqli_query($conn,$query);

                $row2 = mysqli_fetch_assoc($result2);

                $arr[$i]["comment_id"] = $row["comment_id"];
                $arr[$i]["user_name"] = $row2["user_name"];
                $arr[$i]["comment_text"] = $row["text"];
            }

            $obj->disconnect();

            return $arr;
        }

        public function deleteComment($comment_id){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "DELETE FROM comment WHERE comment_id='$comment_id'";

            $status = $conn->query($query);

            $obj->disconnect();
            
            if($status==TRUE){
                return "Comment deleted successfully";
            }
            else{
                return "Failed to delete comment, please try again later";
            }
        }

        public function addComment($user_id,$post_id,$text){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "INSERT INTO comment (comment_id,text,user_id,post_id) 
                      VALUES (null,'$text','$user_id','$post_id')";

            $status = $conn->query($query);

            $obj->disconnect();

            if($status==TRUE){
                return "Comment added successfully";
            }
            else{
                return "Failed to add comment";
            }
        }

        public function checkComments($user_id){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "SELECT comment_id FROM comment WHERE user_id='$user_id'";

            $result = mysqli_query($conn,$query);

            $num_rows = mysqli_num_rows($result);

            if($num_rows > 0){
                $query = "DELETE FROM comment WHERE user_id='$user_id'";
                $status = $conn->query($query);
            }

            $obj->disconnect();
        }
    }
?>