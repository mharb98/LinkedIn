<?php
    require_once('DBConn.php');
    require_once('userDataHandler.php');

    class postDataHandler{

        public function addPost($user_id,$text,$picture){
            $obj = DBConn::getConn();
            $conn = $obj->connect();
            $pic = $conn->real_escape_string($picture);

            $query = "INSERT into post (post_id,text,picture,likes_num,clicks_num,user_id)
                      VALUES (null,'$text','$pic',0,0,'$user_id')";

            $status = $conn->query($query);

            $obj->disconnect();

            if($status==TRUE){
                return "Post added successfully";
            }
            else{
                return "Failed to add post";
            }
        }
        
        public function getPosts($user_id,$belongs){
            $obj = DBConn::getConn();
            $conn = $obj->connect();
            if($belongs=="1"){
                $query = "SELECT * FROM post WHERE user_id='$user_id'";
            }
            else{
                $query = "SELECT * FROM post WHERE user_id<>'$user_id'";
            }

            $result = mysqli_query($conn,$query);

            $num_rows = mysqli_num_rows($result);

            $arr = array();

            for($i=0;$i<$num_rows;$i++){
                $row = mysqli_fetch_assoc($result);
                $arr[$i]["picture"] = base64_encode($row["picture"]);
                $arr[$i]["post_id"] = $row["post_id"];
                $arr[$i]["text"] = $row["text"];
                $arr[$i]["likes_num"] = $row["likes_num"];
                
                $user_id = $row["user_id"];

                $userDataHandler = new userDataHandler();

                $user_data = $userDataHandler->getUserInfo($user_id);

                $type = $user_data["type"];
                $user_name = $user_data["user_name"];

                $arr[$i]["type"] = $type;
                $arr[$i]["user_name"] = $user_name;
                $arr[$i]["user_id"] = $user_id;
            }

            return $arr;
        }

        public function deletePost($post_id){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "DELETE FROM comment WHERE post_id='$post_id'";

            $status = $conn->query($query);

            if($status==FALSE){
                $obj->disconnect();
                return "Failed to delete post at comment, please try again later";
            }
            
            $query = "DELETE FROM likers WHERE post_id='$post_id'";

            $status = $conn->query($query);

            if($status==FALSE){
                $obj->disconnect();
                return "Failed to delete post at likes, please try again later";
            }

            $query = "DELETE FROM post WHERE post_id='$post_id'";

            $status = $conn->query($query);

            $obj->disconnect();

            if($status==FALSE){
                return "Failed to delete post at last one, please try again later";
            }

            $obj->disconnect();
            return "Post deleted successfully";
        }

        public function likePost($user_id,$post_id){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "SELECT * FROM likers WHERE post_id='$post_id' AND user_id='$user_id'";

            $result = mysqli_query($conn,$query);

            $num_rows = mysqli_num_rows($result);

            if($num_rows>0){
                $obj->disconnect();
                return "You already liked this post";
            }

            $query = "INSERT INTO likers (post_id,user_id) VALUES ('$post_id','$user_id')";

            $status = $conn->query($query);


            if($status==FALSE){
               $obj->disconnect();
            }
            
            $query = "SELECT likes_num FROM post WHERE post_id='$post_id'";
            $result = mysqli_query($conn,$query);
            $row = mysqli_fetch_assoc($result);
            $likes_num = $row["likes_num"];
            $likes_num = $likes_num + 1;

            $query = "UPDATE post SET likes_num='$likes_num' WHERE post_id='$post_id'";

            $status = $conn->query($query);

            $obj->disconnect();

            if($status==TRUE){
                return "Post liked successfully";
            }

            return "Could not like the post";
        }

        public function deleteAllPosts($user_id){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "SELECT post_id from likers WHERE user_id='$user_id'";

            $result = mysqli_query($conn,$query);

            $num_rows = mysqli_num_rows($result);

            if($num_rows > 0){
                $query = "DELETE FROM likers WHERE user_id='$user_id'";
                $status = $conn->query($query);
            }

            $query = "SELECT post_id FROM post WHERE user_id='$user_id'";

            $result = mysqli_query($conn,$query);

            $num_rows = mysqli_num_rows($result);

            if($num_rows > 0){
                $query = "DELETE FROM post WHERE user_id='$user_id'";
                $status = $conn->query($query);
            }

            $obj->disconnect();
        }
    }
?>